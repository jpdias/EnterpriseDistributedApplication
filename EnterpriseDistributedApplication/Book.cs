using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;

namespace EnterpriseDistributedApplication
{
    public class Book
    {
        public BsonObjectId _id;
        public static int SerialId { get; set; }
        public int ID { get; set; }
        public string Title { get; set; }
        public double Price { get; set; }
        public string Editor { get; set; }

        public Book(string title, double price, string editor)
        {
            Title = title;
            Price = price;
            Editor = editor;
            SerialId++;
            ID = SerialId;
        }

    }
}
