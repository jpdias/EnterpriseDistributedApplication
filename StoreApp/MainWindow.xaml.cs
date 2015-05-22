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
using System.Windows.Threading;
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
        private readonly DispatcherTimer dispatcherTimer;

        public MainWindow()
        {
            InitializeComponent();

            dispatcherTimer = new DispatcherTimer();
            dispatcherTimer.Tick += new EventHandler(UpdateGUI);
            dispatcherTimer.Interval = new TimeSpan(0, 0, 10);
            dispatcherTimer.Start();

            ops = new OrdersOps("app");
            UpdateGUIOnClick();

        }

        private void UpdateGUI(object sender, EventArgs eventArgs)
        {
            Dispatcher.BeginInvoke(new Action(delegate()
            {
                PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
                PendingListBox.ItemsSource = PendingListOrders;
                PendingListBox.UpdateLayout();
            }));

        }

        private void UpdateGUIOnClick()
        {
            dispatcherTimer.Stop();
            Dispatcher.BeginInvoke(new Action(delegate()
            {
                PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders());
                PendingListBox.ItemsSource = PendingListOrders;
                PendingListBox.UpdateLayout();
            }));
            dispatcherTimer.Start();
        }

        private void loginBtn_Click(object sender, RoutedEventArgs e)
        {
            Authentication auth = new Authentication();

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
            List<Order> pendingOrders = new List<Order>();
            foreach (object listItem in PendingListBox.SelectedItems)
            {
                Order li = listItem as Order;
                pendingOrders.Add(li);
            }
            ops.CheckPendingOrders(pendingOrders);
            UpdateGUIOnClick();
        }


        private void CreateOrderButton_Click(object sender, RoutedEventArgs e)
        {
            //Book book = new Book();
            //Customer customer = new Customer();
            //Order order = new Order(book,1,customer);

            UpdateGUIOnClick();

            MessageBoxResult result = MessageBox.Show("Do you want to print the recipt?", "Confirmation", MessageBoxButton.YesNo, MessageBoxImage.Question);
            if (result == MessageBoxResult.Yes)
            {
                //PrintOrder(idOrder);
            }
        }

        private void PrintOrder(Order idOrder)
        {

        }
    }
}
