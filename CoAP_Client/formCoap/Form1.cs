using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using CoAP.Util;
using System.Threading;
using Newtonsoft.Json;
using System.Threading.Tasks;
using System.Net;
using System.IO;
using System.IO.Compression;
 
namespace formCoap
{

 
    public partial class Form1 : Form
    {

        //定义一个结构体类型
        struct pannode
        {
            public string temp;
            public string humi;
            public string water;
            public string smog;
            public string people;
        };  
        //定义一个结构体数组
        pannode[] node = new pannode[3];

        string lineshow1 = "";
        string lineshow2 = "";
        string lineshow3 = "";

        Thread t1,t2,t3;
        string [] url= { 
                            "coap://[2001:da8:c004:2:212:4b00:5af:81a1]:5683/config?param=allsensor",
                            "coap://[2001:da8:c004:2:212:4b00:5af:80f0]:5683/config?param=allsensor",
                            "coap://[2001:da8:c004:2:212:4b00:5af:8123]:5683/config?param=allsensor" 
                       };
        int i = 0;

        //定义可设置的参数
        string node1id, node2id, node3id;
        string ip6add;
        string wsnkey;


        //解析JSON
        class Program
        {
            static void changecoap(string[] args)
            {

            }
        }

        public class RootObject
        {
            //{"temp":"26","humi":"29","water":"1","smog":"0","people":"1"}
            public string temp { get; set; }
            public string humi { get; set; }
            public string water { get; set; }
            public string smog { get; set; }
            public string people { get; set; }
        }  



        public Form1()
        {
            InitializeComponent();
        }

       


        //CoAP：get方法
        private void button1_Click(object sender, EventArgs e)
        {

            t1 = new Thread(new ThreadStart(getcoap));//无参数的委托
            t1.Start();
            t2 = new Thread(new ThreadStart(getcoap1));//无参数的委托
            t2.Start();
            t3 = new Thread(new ThreadStart(getcoap2));//无参数的委托
            t3.Start();
            timer1.Enabled = true;
            timer2.Enabled = true;
            timer3.Enabled = true;
            this.ovalS1.BackColor = Color.Green;
            this.ovalS2.BackColor = Color.Green;
            this.ovalS3.BackColor = Color.Green;
            Thread.Sleep(3000);
            timer4.Enabled = true;

           


        }


        private void getcoap()
        {
            while (true)
            {
                CoAP.Response response=null;
                var client = new CoAP.CoapClient();

                // create a new client
                client.Timeout = 5000;
                // set the Uri to visit
                client.Uri = new Uri(url[0]);



                // now send a GET request to say hello~
                try
                {
                    response = client.Get();
                    lineshow1 = response.PayloadString;// + "\r\n";
                    //取json中的数据到结构体数组
                    json2var1(lineshow1);
                    this.ovalS1.BackColor = Color.Green;

                }
                catch
                {
                    //lineshow1 = "error";
                    //this.ovalS1.BackColor = Color.Red;
                    goto subexit;
                    
                }               
                
            subexit:
                System.Threading.Thread.Sleep(10000);
            }
        
        }
        private void getcoap1()
        {
            while (true)
            {
                CoAP.Response response = null;
                var client = new CoAP.CoapClient();

                // create a new client
                client.Timeout = 5000;
                // set the Uri to visit
                client.Uri = new Uri(url[1]);



                // now send a GET request to say hello~
                try
                {
                    response = client.Get();
                    lineshow2 = response.PayloadString;// + "\r\n";
                    //取json中的数据到结构体数组
                    json2var2(lineshow2);
                    this.ovalS2.BackColor = Color.Green;

                }
                catch
                {
                   // lineshow2 = "error";
                    //this.ovalS2.BackColor = Color.Red;
                    goto subexit;

                }

            subexit:
                System.Threading.Thread.Sleep(10000);
            }

        }
        private void getcoap2()
        {
            while (true)
            {
                CoAP.Response response = null;
                var client = new CoAP.CoapClient();

                // create a new client
                client.Timeout = 5000;
                // set the Uri to visit
                client.Uri = new Uri(url[2]);



                // now send a GET request to say hello~
                try
                {
                    response = client.Get();
                    lineshow3 = response.PayloadString;// + "\r\n";
                    //取json中的数据到结构体数组
                    json2var3(lineshow3);
                    this.ovalS3.BackColor = Color.Green;

                }
                catch
                {
                   // lineshow3 = "error";
                    //this.ovalS3.BackColor = Color.Red;
                    goto subexit;

                }

            subexit:
                System.Threading.Thread.Sleep(10000);
            }

        }


        //CoAP：POST方法
        private void button2_Click(object sender, EventArgs e)
        {
            CoAP.Response response;
            String strPayload;
            // create a new client
            var client = new CoAP.CoapClient();
            client.Timeout = 5000;
            // set the Uri to visit
            //client.Uri = new Uri(txtURI.Text);
            // now send a GET request to say hello~
            strPayload = txtPostPayload.Text;
            response = client.Post(strPayload);
            try
            {
                this.textBox1.AppendText(response.PayloadString + "\r\n");
            }
            catch
            {
                MessageBox.Show("time out!");
            }
 
        }

        private void txtURI_TextChanged(object sender, EventArgs e)
        {

        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            textBox1.AppendText(lineshow1);
            //节点一显示
            txttemp1.Text = node[0].temp;
            txthumi1.Text = node[0].humi;
          



  
            if (node[0].smog == "0")
            {
                this.ovalS1smog.BackColor = Color.Green;
            }
            else if (node[0].smog == "1")
            {
                this.ovalS1smog.BackColor = Color.Red;

            }
            if (node[0].water == "0")
            {
                this.ovalS1water.BackColor = Color.Green;
            }
            else if (node[0].water == "1")
            {
                this.ovalS1water.BackColor = Color.Red;

            }
            if (node[0].people == "0")
            {
                this.ovalS1people.BackColor = Color.Green;
            }
            else if (node[0].people == "1")
            {
                this.ovalS1people.BackColor = Color.Red;

            }




        }

        private void timer2_Tick(object sender, EventArgs e)
        {
            textBox1.AppendText(lineshow2);
            txttemp2.Text = node[1].temp;
            txthumi2.Text = node[1].humi;

            if (node[1].smog == "0")
            {
                this.ovalS2smog.BackColor = Color.Green;
            }
            else if (node[1].smog == "1")
            {
                this.ovalS2smog.BackColor = Color.Red;

            }
            if (node[1].water == "0")
            {
                this.ovalS2water.BackColor = Color.Green;
            }
            else if (node[1].water == "1")
            {
                this.ovalS2water.BackColor = Color.Red;

            }
            if (node[1].people == "0")
            {
                this.ovalS2people.BackColor = Color.Green;
            }
            else if (node[1].people == "1")
            {
                this.ovalS2people.BackColor = Color.Red;

            }

        }

        private void timer3_Tick(object sender, EventArgs e)
        {
            textBox1.AppendText(lineshow3);
            txttemp3.Text = node[2].temp;
            txthumi3.Text = node[2].humi;

            if (node[2].smog == "0")
            {
                this.ovalS3smog.BackColor = Color.Green;
            }
            else if (node[2].smog == "1")
            {
                this.ovalS3smog.BackColor = Color.Red;

            }
            if (node[2].water == "0")
            {
                this.ovalS3water.BackColor = Color.Green;
            }
            else if (node[2].water == "1")
            {
                this.ovalS3water.BackColor = Color.Red;

            }
            if (node[2].people == "0")
            {
                this.ovalS3people.BackColor = Color.Green;
            }
            else if (node[2].people == "1")
            {
                this.ovalS3people.BackColor = Color.Red;

            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            t1.Abort();
            t2.Abort();
            t3.Abort();
            timer1.Enabled = false;
            timer2.Enabled = false;
            timer3.Enabled = false;
            timer4.Enabled = false;

            this.ovalS1.BackColor = Color.Red;
            this.ovalS2.BackColor = Color.Red;
            this.ovalS3.BackColor = Color.Red;


        }

        private void button4_Click(object sender, EventArgs e)
        {
     
        }

        private void boxtemp_TextChanged(object sender, EventArgs e)
        {
           // txttemp1.Text = temp1;

        }

        private void json2var1(string scoapstr)
        {
           
            string tt=scoapstr;
            string jsonText = makeJSON(tt);
            //MessageBox.Show(jsonText);
            //textBox1.AppendText(jsonText);

            
            RootObject rb = JsonConvert.DeserializeObject<RootObject>(jsonText);
            //存入变量
            
            node[0].temp= rb.temp;
            node[0].humi = rb.humi;
            node[0].smog = rb.smog;
            node[0].water = rb.water;
            node[0].people = rb.people;
            SendSms1(node1id, node[0].temp, node[0].humi);
            
        }
        private void json2var2(string scoapstr)
        {

            string tt = scoapstr;
            string jsonText = makeJSON(tt);
            //MessageBox.Show(jsonText);
            //textBox1.AppendText(jsonText);


            RootObject rb = JsonConvert.DeserializeObject<RootObject>(jsonText);
            //存入变量

            node[1].temp = rb.temp;
            node[1].humi = rb.humi;
            node[1].smog = rb.smog;
            node[1].water = rb.water;
            node[1].people = rb.people;
            SendSms1(node2id , node[1].temp, node[1].humi);

        }
        private void json2var3(string scoapstr)
        {

            string tt = scoapstr;
            string jsonText = makeJSON(tt);
            //MessageBox.Show(jsonText);
            //textBox1.AppendText(jsonText);


            RootObject rb = JsonConvert.DeserializeObject<RootObject>(jsonText);
            //存入变量

            node[2].temp = rb.temp;
            node[2].humi = rb.humi;
            node[2].smog = rb.smog;
            node[2].water = rb.water;
            node[2].people = rb.people;
            SendSms1(node3id , node[2].temp, node[2].humi);

        }


        private string  makeJSON(string jj)
        {
            //string tempstr ="\"" + jj.Replace("\"", "\\\"") + "\"";
            //return tempstr.Replace("\r\n", "");
            return jj.Replace("\"", "'");
            //return jj.Replace("\"", "\\\"");
        
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }

        private void label2_Click(object sender, EventArgs e)
        {

        }

        private void label4_Click(object sender, EventArgs e)
        {

        }

        private void textBox3_TextChanged(object sender, EventArgs e)
        {

        }

        private void txttemp1_TextChanged(object sender, EventArgs e)
        {

        }

        private void groupBox1_Enter(object sender, EventArgs e)
        {

        }

        private void label7_Click(object sender, EventArgs e)
        {

        }

        private void ovalShape2_Click(object sender, EventArgs e)
        {

        }

        private void ovalShape1_Click(object sender, EventArgs e)
        {

        }

        private void txttemp1_TextChanged_1(object sender, EventArgs e)
        {

        }

        private void label3_Click(object sender, EventArgs e)
        {

        }

        private void txthumi1_TextChanged(object sender, EventArgs e)
        {

        }

        private void txttemp2_TextChanged(object sender, EventArgs e)
        {

        }

        private void label10_Click(object sender, EventArgs e)
        {

        }

        private void txthumi2_TextChanged(object sender, EventArgs e)
        {

        }

        private void txttemp3_TextChanged(object sender, EventArgs e)
        {

        }

        private void label18_Click(object sender, EventArgs e)
        {

        }

        private void txthumi3_TextChanged(object sender, EventArgs e)
        {

        }

        private void 联系我们ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("学生：梁金荣\n指导老师：何辉");
        }

        private void 退出ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        public void 设置报警参数ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Form2 a = new Form2();
            a.Show(this);

        }

        public void timer4_Tick(object sender, EventArgs e)
        {
            //templine = int.Parse(Form2.F2templine);
            //humiline = int.Parse(Form2.F2humiline);
        nextloop:
            try
            {
                //节点一温度报警
                if (int.Parse(node[0].temp) >= Form2.F2templine)
                {
                    this.ovalS1temp.BackColor = Color.Red;
                    timer5.Enabled = true;
                }
                else if (int.Parse(node[0].temp) < Form2.F2templine)
                {
                    this.ovalS1temp.BackColor = Color.Green;
                    timer5.Enabled = false;
                }
                //节点一湿度报警
                if (int.Parse(node[0].humi) >= Form2.F2humiline)
                {
                    this.ovalS1humi.BackColor = Color.Red;
                    timer5.Enabled = true;
                }
                else if (int.Parse(node[0].humi) < Form2.F2humiline)
                {
                    this.ovalS1humi.BackColor = Color.Green;
                    timer5.Enabled = false;
                }

                //节点二温度报警
                if (int.Parse(node[1].temp) >= Form2.F2templine)
                {
                    this.ovalS2temp.BackColor = Color.Red;
                    //timer5.Enabled = true;
                }
                else if (int.Parse(node[1].temp) < Form2.F2templine)
                {
                    this.ovalS2temp.BackColor = Color.Green;
                    //timer5.Enabled = false;
                }
                //节点二湿度报警
                if (int.Parse(node[1].humi) >= Form2.F2humiline)
                {
                    this.ovalS2humi.BackColor = Color.Red;
                    //timer5.Enabled = true;
                }
                else if (int.Parse(node[1].humi) < Form2.F2humiline)
                {
                    this.ovalS2humi.BackColor = Color.Green;
                    //timer5.Enabled = false;
                }

                //节点三温度报警
                if (int.Parse(node[2].temp) >= Form2.F2templine)
                {
                    this.ovalS3temp.BackColor = Color.Red;
                    //timer5.Enabled = true;
                }
                else if (int.Parse(node[2].temp) < Form2.F2templine)
                {
                    this.ovalS3temp.BackColor = Color.Green;
                    //timer5.Enabled = false;
                }
                //节点三湿度报警
                if (int.Parse(node[2].humi) >= Form2.F2humiline)
                {
                    this.ovalS3humi.BackColor = Color.Red;
                    //timer5.Enabled = true;
                }
                else if (int.Parse(node[2].humi) < Form2.F2humiline)
                {
                    this.ovalS3humi.BackColor = Color.Green;
                    //timer5.Enabled = false;
                }
            }
            catch {

                goto nextloop;
            
            }





        }


        private void timer5_Tick(object sender, EventArgs e)
        {
            //System.Media.SystemSounds.Asterisk.Play();
            //System.Media.SystemSounds.Exclamation.Play();
            //System.Media.SystemSounds.Hand.Play();
            //System.Media.SystemSounds.Beep.Play();
            System.Media.SystemSounds.Asterisk.Play(); 
        }

        private void label25_Click(object sender, EventArgs e)
        {

        }

        //发送数据至数据库
        public bool SendSms1(string id, string temp, string humi)
        {
            bool flag = false;
            // string userName = "admin";
            // string passWord = "admin";
            try
            {
                string Url = "http://[" + ip6add  + "]:8088/ycm/curltest/posttest.php";



                HttpWebRequest httpWReq = (HttpWebRequest)WebRequest.Create(Url);

                Encoding encoding = new UTF8Encoding();
                // string postData = "{\"data\":{\"number\":\"" + arrMobile + "\",\"text\":\"" + sms + "\"},\"port\":\"" + arrPort + "\"}}";  
                string postData = "{\"id\":\"" + id + "\",\"temp\":\"" + temp + "\",\"humi\":\"" + humi + "\"}";
                byte[] data = encoding.GetBytes(postData);

                httpWReq.ProtocolVersion = HttpVersion.Version11;
                httpWReq.Method = "POST";
                httpWReq.ContentType = "application/json"; //charset=UTF-8";  
                httpWReq.Headers.Add("wsn-key", wsnkey );
                //httpWReq.Headers.Add("X-Amzn-Accept-Type",  
                // "com.amazon.device.messaging.ADMSendResult@1.0");  

                //string _auth = string.Format("{0}:{1}", userName, passWord);
                //string _enc = Convert.ToBase64String(Encoding.ASCII.GetBytes(_auth));
                //string _cred = string.Format("{0} {1}", "Basic", _enc);
                //httpWReq.Headers.Add(HttpRequestHeader.Authorization,  
                // "Bearer " + accessToken);  

                //httpWReq.Headers[HttpRequestHeader.Authorization] = _cred;
                httpWReq.ContentLength = data.Length;


                Stream stream = httpWReq.GetRequestStream();
                stream.Write(data, 0, data.Length);
                stream.Close();

                HttpWebResponse response = (HttpWebResponse)httpWReq.GetResponse();
                string s = response.ToString();

                StreamReader reader = new StreamReader(response.GetResponseStream());
                String jsonresponse = "";
                //String temp = null;
                while ((temp = reader.ReadLine()) != null)
                {
                    jsonresponse += temp;
                }
                textBox1.AppendText(jsonresponse);
                return true;
            }
            catch (WebException e)
            {

                using (WebResponse response = e.Response)
                {
                    HttpWebResponse httpResponse = (HttpWebResponse)response;
                    textBox1.AppendText(httpResponse.StatusCode.ToString());
                    using (Stream data = response.GetResponseStream())
                    using (var reader = new StreamReader(data))
                    {
                        string text = reader.ReadToEnd();
                        textBox1.AppendText(text);
                    }
                }
                return flag;
            }
        }


        //给参数设置初值
        private void button4_Click_1(object sender, EventArgs e)
        {
            node1id = txtn1.Text; //节点编号
            node2id = txtn2.Text;
            node3id = txtn3.Text;

            ip6add = txtip.Text;  //服务器地址
            wsnkey = txtkey.Text; //秘钥
        }


        //在界面启动时给参数赋值
        private void Form1_Load(object sender, EventArgs e)
        {
            node1id = txtn1.Text; //节点编号
            node2id = txtn2.Text;
            node3id = txtn3.Text;

            ip6add = txtip.Text;  //服务器地址
            wsnkey = txtkey.Text; //秘钥
        } 
     
    }
}
