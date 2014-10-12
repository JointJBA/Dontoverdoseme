using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using MySql.Data.MySqlClient;
using System.Timers;

namespace TwilioContact
{
    class Program
    {
        static string url = "";
        static Dictionary<DateTime, string[]> scheduler;
        static void Main(string[] args)
        {
            string[] uidsched = GetDrugs();
            scheduler = GetScheduleWithPhone(uidsched);
            Timer t = new Timer(1);
            t.Elapsed += new ElapsedEventHandler(t_Elapsed);
            Console.ReadKey();
        }

        static void t_Elapsed(object sender, ElapsedEventArgs e)
        {
            Dictionary<DateTime, string[]> temp = new Dictionary<DateTime,string[]>(scheduler);
            foreach (KeyValuePair<DateTime, string[]> item in temp)
            {
                if (CheckSchedule(item.Key, item.Value[0], item.Value[1], item.Value[2]))
                {
                    scheduler.Remove(item.Key);
                }
            }
        }

        public static void SendMessage(string to, string message)
        {
            string from = "+19292587775";
            HttpPost("https://api.twilio.com/2010-04-01/Accounts/AC4f901b3bf08620609d4f9a2f2812fc21/Messages.json", "From=" + from + "&Body=" + message + "&To=" + to);
        }

        public static string HttpPost(string URI, string Parameters)
        {
            WebRequest req = WebRequest.Create(URI);
            req.ContentType = "application/x-www-form-urlencoded";
            req.Method = "POST";
            req.PreAuthenticate = true;
            req.AuthenticationLevel = System.Net.Security.AuthenticationLevel.MutualAuthRequested;
            string username = "AC4f901b3bf08620609d4f9a2f2812fc21";
            string password = "52080d9ee2da65f3936561403d0e1cc0";
            String encoded = System.Convert.ToBase64String(System.Text.Encoding.GetEncoding("ISO-8859-1").GetBytes(username + ":" + password));
            req.Headers.Add("Authorization", "Basic " + encoded);
            byte[] bytes = System.Text.Encoding.ASCII.GetBytes(Parameters);
            req.ContentLength = bytes.Length;
            System.IO.Stream os = req.GetRequestStream();
            os.Write(bytes, 0, bytes.Length); //Push it out there
            os.Close();
            System.Net.WebResponse resp = req.GetResponse();
            if (resp == null) return null;
            System.IO.StreamReader sr = new System.IO.StreamReader(resp.GetResponseStream());
            return sr.ReadToEnd().Trim();
        }

        public static string HTTP_GET(string Url, string Data)
        {
            string Out = String.Empty;
            System.Net.WebRequest req = System.Net.WebRequest.Create(Url + (string.IsNullOrEmpty(Data) ? "" : "?" + Data));
            try
            {
                System.Net.WebResponse resp = req.GetResponse();
                using (System.IO.Stream stream = resp.GetResponseStream())
                {
                    using (System.IO.StreamReader sr = new System.IO.StreamReader(stream))
                    {
                        Out = sr.ReadToEnd();
                        sr.Close();
                    }
                }
            }
            catch (ArgumentException ex)
            {
                Out = string.Format("HTTP_ERROR :: The second HttpWebRequest object has raised an Argument Exception as 'Connection' Property is set to 'Close' :: {0}", ex.Message);
            }
            catch (WebException ex)
            {
                Out = string.Format("HTTP_ERROR :: WebException raised! :: {0}", ex.Message);
            }
            catch (Exception ex)
            {
                Out = string.Format("HTTP_ERROR :: Exception raised! :: {0}", ex.Message);
            }
            return Out;
        }

        public static string[] GetDrugs() //returns uid, drugname, schedule
        {
            string[] datum = HTTP_GET("http://dontoverdoseme.ngrok.com/dontoverdoseme/remoteaccess.php", "a=drugs").Split(new char[] { '|' }, StringSplitOptions.RemoveEmptyEntries);
            return datum;
        }

        public static bool CheckSchedule(DateTime dt, string name, string phone, string med)
        {
            if (dt.Hour == DateTime.Now.Hour && dt.Minute == DateTime.Now.Minute)
            {
                SendMessage(phone, "Hey " + name + ", please don't forget to take " + med + " at this moment.");
                return true;
            }
            return false;
        }

        public static Dictionary<DateTime, string[]> GetScheduleWithPhone(string[] drugs) //returns a list of schedule with name, phone and dname
        {
            Dictionary<DateTime, string[]> result = new Dictionary<DateTime, string[]>();
            for (int i = 0; i < drugs.Length; i+=3)
            {
                string[] datum = HTTP_GET("http://dontoverdoseme.ngrok.com/dontoverdoseme/remoteaccess.php", "a=user&id=" + drugs[i]).Split(new char[] { '|' }, StringSplitOptions.RemoveEmptyEntries);
                string[] dates = drugs[i + 2].Split(new char[] { ',' }, StringSplitOptions.RemoveEmptyEntries);
                for (int j = 0; j < dates.Length; j++)
                {
                    result.Add(DateTime.Parse(dates[j]), new string[] { datum[0], datum[1], drugs[i + 1] }); // name, phone, drug name
                }
            }
            return result;
        }


    }
}
