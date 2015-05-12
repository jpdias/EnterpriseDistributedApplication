using System;
using System.Collections.Generic;
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
       
        public BsonObjectId _id;
        [DataMember]
        public static int SerialId { get; set; }
        [DataMember]
        public int ID { get; set; }
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
            Title = title;
            Price = price;
            Editor = editor;
            Stock = stock;
            SerialId++;
            ID = SerialId;
        }

    }
}
