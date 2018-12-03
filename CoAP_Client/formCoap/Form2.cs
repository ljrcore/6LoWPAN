using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace formCoap
{
    public partial class Form2 : Form
    {
        public static int F2templine = 50, F2humiline = 50;
        //public static string F2templine="50", F2humiline="50";
        public Form2()
        {
            InitializeComponent();
        }

        public void button1_Click(object sender, EventArgs e)
        {
            F2templine = int.Parse(templinebox.Text);
            F2humiline = int.Parse(humilinebox.Text);
            
            MessageBox.Show("设置成功！");
            this.Close();

        }

    }
}
