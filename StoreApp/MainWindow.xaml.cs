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
using MongoDB.Bson;
using PdfSharp.Drawing;
using PdfSharp.Drawing.Layout;
using PdfSharp.Pdf;
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
        public ObservableCollection<Customer> CustomersInfo;
        public ObservableCollection<Book> BooksInfo;

        public MainWindow()
        {
            InitializeComponent();
            this.DataContext = this;

            dispatcherTimer = new DispatcherTimer();
            dispatcherTimer.Tick += new EventHandler(UpdateGUI);
            dispatcherTimer.Interval = new TimeSpan(0, 0, 10);
            dispatcherTimer.Start();

            ops = new OrdersOps("app");
            NewGrid.Visibility = Visibility.Hidden;
            UpdateGUIOnClick();

        }

        private void UpdateGUI(object sender, EventArgs eventArgs)
        {
            Dispatcher.BeginInvoke(new Action(delegate()
            {
                PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders(DateTime.Now));
                PendingListBox.ItemsSource = PendingListOrders;
                PendingListBox.UpdateLayout();
            }));

        }

        private void UpdateGUIOnClick()
        {
            dispatcherTimer.Stop();
            Dispatcher.BeginInvoke(new Action(delegate()
            {
                PendingListOrders = new ObservableCollection<Order>(ops.GetPendingOrders(DateTime.Now));
                PendingListBox.ItemsSource = PendingListOrders;
                PendingListBox.UpdateLayout();

                CustomersInfo = new ObservableCollection<Customer>(ops.GetAllCustomers());
                costumers.ItemsSource = CustomersInfo;
                costumers.UpdateLayout();

                BooksInfo = new ObservableCollection<Book>(ops.GetAllBooks());
                books.ItemsSource = BooksInfo;
                books.UpdateLayout();
                
                
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
                MainGrid.Visibility = Visibility.Visible;
            }
            else
                MessageBox.Show("Authentication fail");
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
            Book book = books.SelectedItem as Book;
            Customer customer;
            if ((bool) New.IsChecked)
            {
                var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                var random = new Random();
                var pass = new string(
                    Enumerable.Repeat(chars, 8)
                              .Select(s => s[random.Next(s.Length)])
                              .ToArray());
                customer = new Customer(email.Text, name.Text,addr.Text,pass);
                Email.SendEmail(customer.Email, "New Account", "Welcome to EDA Store! \n \n Password:" + customer.Password);

            }
            else
            {
                customer = costumers.SelectedItem as Customer;
            }

            var quantity = int.Parse(quant.Text);
            Order order = new Order(book, quantity , customer);

            var result = ops.ProcessNewOrder(order);

            state.Text = result.State.CurrentState.ToString();
            UpdateGUIOnClick();
            if (result.State.CurrentState == State.state.Dispatched)
            {
                MessageBoxResult text = MessageBox.Show("Do you want to print the receipt?", "Confirmation",
                    MessageBoxButton.YesNo, MessageBoxImage.Question);
                if (text == MessageBoxResult.Yes)
                {
                    PrintOrder(order);
                }
            }
        }

        private void PrintOrder(Order idOrder)
        {
            var total = idOrder.Quantity*idOrder.Book.Price;
            PdfDocument document = new PdfDocument();
            document.Info.Title = "Receipt";

            // Create an empty page
            PdfPage page = document.AddPage();

            // Get an XGraphics object for drawing
            XGraphics gfx = XGraphics.FromPdfPage(page);

            // Create a font
            XFont font = new XFont("Times New Roman", 10, XFontStyle.Bold);

            var text = "Receipt\n\n" +
                       "Date:"+DateTime.Now.ToShortDateString()+"\nBook: " + idOrder.Book.Title + "\nEditor: " + idOrder.Book.Editor + "\n" + "Quantity: " +
                       idOrder.Quantity + "\n" + "Total: " + total + "\n\nThank you, from EDA Developers!";
            // Draw the text
            XTextFormatter tf = new XTextFormatter(gfx);

            XRect rect = new XRect(40, 100, 500, 440);
            gfx.DrawRectangle(XBrushes.White, rect);
            //tf.Alignment = ParagraphAlignment.Left;
            tf.DrawString(text, font, XBrushes.Black, rect, XStringFormats.TopLeft);


            // Save the document...
            string filename = "Receipt"+idOrder._id.ToString()+".pdf";
            document.Save(filename);
            // ...and start a viewer.
            Process.Start(filename);
        }

        private void New_Checked(object sender, RoutedEventArgs e)
        {
            costumers.Visibility = Visibility.Hidden;
            NewGrid.Visibility = Visibility.Visible;
            UpdateGUIOnClick();
        }

        private void New_OnUnchecked(object sender, RoutedEventArgs e)
        {
            NewGrid.Visibility = Visibility.Hidden;
            costumers.Visibility = Visibility.Visible;
            UpdateGUIOnClick();
        }
    }
}
