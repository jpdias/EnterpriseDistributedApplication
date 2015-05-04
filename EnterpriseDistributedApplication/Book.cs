using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;

namespace EnterpriseDistributedApplication
{
    class Book
    {
        public Book(string title, double price, string editor)
        {
            Title = title;
            Price = price;
            Editor = editor;
            SerialId++;
            ID = SerialId;
        }

        private static int SerialId { get; set; }
        private int ID { get; set; } 
        private string Title { get; set; }
        private double Price { get; set; }
        private string Editor { get; set; }

    }
}
