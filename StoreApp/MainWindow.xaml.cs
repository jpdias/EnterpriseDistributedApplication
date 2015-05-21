using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using System.Linq;
using System.Net.NetworkInformation;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using EnterpriseDistributedApplication;
using Store;


namespace StoreApp
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public ObservableCollection<Order> PendingListOrders;
        OrdersOps ops;

        public MainWindow()
        {
            InitializeComponent();



            ops = new OrdersOps("app");
            PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
            PendingListBox.ItemsSource = PendingListOrders;
            OrdersOps.ThrowEvent += (s, e) =>
            {
                if (Application.Current != null)
                {
                    Application.Current.Dispatcher.BeginInvoke((Action)(DoSomething));
                }
            };

        }

        private static void DoSomething()
        {

            Debug.WriteLine("HEYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY");
            // PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
            // PendingListBox.ItemsSource = PendingListOrders;
        }

        private void loginBtn_Click(object sender, RoutedEventArgs e)
        {
            Store.Authentication auth = new Store.Authentication();

            var user = username.Text;
            var pass = password.Password;
            if (auth.AuthenticateUser(new User(user, pass)))
            {
                Login.Visibility = Visibility.Hidden;
                ControlPanel.Visibility = Visibility.Visible;
            }
            else
                MessageBox.Show("Auth fail");
        }

        private void CheckPending_Click(object sender, RoutedEventArgs e){
        
            for (int i = 0; i < PendingListBox.SelectedItems.Count; i++)
            {
                Order li = PendingListBox.SelectedItems[i] as Order;
                Debug.WriteLine(li.Book.Title);
            }
        }

    }
}
