using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
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
        public static ObservableCollection<Book> TheList = new ObservableCollection<Book>();
        
        public MainWindow()
        {
            InitializeComponent();
        }

        public static void AddToList(Book book)
        {
            Application.Current.Dispatcher.BeginInvoke(
                System.Windows.Threading.DispatcherPriority.Normal,
                (Action)delegate()
                {
                    TheList.Add(book);
                    
                });
           
        }

        private void CheckBoxZone_Checked(object sender, RoutedEventArgs e)
        {
            Debug.WriteLine("line selected");
        }
    }
     
}
   