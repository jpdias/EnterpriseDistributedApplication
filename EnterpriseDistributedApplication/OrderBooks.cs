using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;

namespace EnterpriseDistributedApplication
{
    [DataContract(Name = "OrderBooks")]
    [KnownType(typeof(Book))]
    [KnownType(typeof(int))]
    [KnownType(typeof(Customer))]
    [KnownType(typeof(State))]
    public class OrderBooks
    {
        public ObjectId _id;

        [DataMember(Name = "Book")]
        public Book Book { get; set; }

        [DataMember(Name = "Quantity")]
        public int Quantity { get; set; }



        public OrderBooks(Book book, int quantity)
        {

            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId,
                (short)Process.GetCurrentProcess().Id, 1);
            Book = book;
            Quantity = quantity;

        }
    }
}
