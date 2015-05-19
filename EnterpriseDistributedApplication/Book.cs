using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;
using System.Runtime.Serialization;
using MongoDB.Bson.Serialization.Attributes;


namespace EnterpriseDistributedApplication
{
    [DataContract(Name = "Book")]
    public class Book
    {
        [DataMember(Name = "_id")]
        [BsonId]
        [BsonRepresentation(BsonType.ObjectId)]
        public string _id;
        [DataMember(Name="Title")]
        public string Title { get; set; }
        [DataMember(Name = "Price")]
        public double Price { get; set; }
        [DataMember(Name = "Editor")]
        public string Editor { get; set; }
        [DataMember(Name = "Stock")]
        public int Stock { get; set; }

        public Book(string title, double price, string editor, int stock)
        {
            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId, (short)Process.GetCurrentProcess().Id, 1).ToJson();
            Title = title;
            Price = price;
            Editor = editor;
            Stock = stock;
        }

        public Book(string id,string title, double price, string editor)
        {
            _id = id;
            Title = title;
            Price = price;
            Editor = editor;
        }

    }
}
