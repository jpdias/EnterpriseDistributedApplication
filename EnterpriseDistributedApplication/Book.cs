using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;
using System.Runtime.Serialization;


namespace EnterpriseDistributedApplication
{
    [DataContract]
    public class Book
    {
        [DataMember]
        public BsonObjectId _id;
        [DataMember]
        public string Title { get; set; }
        [DataMember]
        public double Price { get; set; }
        [DataMember]
        public string Editor { get; set; }
        [DataMember]
        public int Stock { get; set; }

        public Book(string title, double price, string editor, int stock)
        {
            _id = new BsonObjectId(new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId, (short)Process.GetCurrentProcess().Id, 1));
            Title = title;
            Price = price;
            Editor = editor;
            Stock = stock;
        }

        public Book(string title, double price, string editor)
        {
            Title = title;
            Price = price;
            Editor = editor;
        }

    }
}
