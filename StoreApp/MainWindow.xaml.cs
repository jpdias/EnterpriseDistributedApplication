using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
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
        private EventThrower _Thrower;

      
        public MainWindow()
        {
            InitializeComponent();
            ops = new OrdersOps("app");
            PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
            PendingListBox.ItemsSource = PendingListOrders;
            this._Thrower = new EventThrower();
            this._Thrower.ThrowEvent += (sender, args) => { DoSomething(); };
        }


        private void DoSomething()
        {
           Debug.WriteLine("HEYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY");
           PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
           PendingListBox.ItemsSource = PendingListOrders;
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

        private void CheckPending_Click(object sender, RoutedEventArgs e)
        {

        }

    }
}
