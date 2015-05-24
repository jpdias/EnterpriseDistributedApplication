using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Net;
using System.Runtime.Serialization.Json;
using System.Text;
using System.Threading.Tasks;
using System.Web.Script.Serialization;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using EnterpriseDistributedApplication;

namespace Warehouse
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public static ObservableCollection<OrderBooks> TheList = new ObservableCollection<OrderBooks>();
        public static int Factor = 10;
        public MainWindow()
        {
            InitializeComponent();
        }

        public static void AddToList(OrderBooks order)
        {
            Application.Current.Dispatcher.BeginInvoke(
                System.Windows.Threading.DispatcherPriority.Normal,
                (Action)delegate()
                {
                    TheList.Add(order);
                    
                });
           
        }

        private void CheckBoxZone_Checked(object sender, RoutedEventArgs e)
        {
            OrderBooks temp = null;

            CheckBox current = (CheckBox)e.OriginalSource;

            if (current.Content != null)
            {
                foreach (var order in TheList.Where(order => order.Book.Title == current.Content))
                {
                    temp = order;
                    temp.Book.Stock = order.Quantity*Factor;
                    TheList.Remove(order);
                    break;
                }
                
            }
            if (temp != null) {

                var httpWebRequest = (HttpWebRequest)WebRequest.Create("http://localhost:46615/StoreService.svc/api/warehouse/package");
                httpWebRequest.ContentType = "application/json";
                httpWebRequest.Method = "POST";
               
                using (var streamWriter = new StreamWriter(httpWebRequest.GetRequestStream()))
                {
                    DataContractJsonSerializer ser = new DataContractJsonSerializer(typeof(OrderBooks));
                    MemoryStream ms = new MemoryStream();
                    ser.WriteObject(ms, temp);
                    string jsonString = Encoding.UTF8.GetString(ms.ToArray());
                    ms.Close();
                    streamWriter.Write(jsonString);
                   
                }

                var httpResponse = (HttpWebResponse)httpWebRequest.GetResponse();
                using (var streamReader = new StreamReader(httpResponse.GetResponseStream()))
                {
                    var result = streamReader.ReadToEnd();
                }
            }
        }
    }
     
}
   