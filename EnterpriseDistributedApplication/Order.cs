using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;

namespace EnterpriseDistributedApplication
{
    public class Order
    {
        public BsonObjectId _id;
        public Book Book { get; set; }
        public int Quantity { get; set; }
        public Customer Customer { get; set; }
        public State State { get; set; }
        public Order(Book book, int quantity, Customer customer, State state)
        {
            Book = book;
            Quantity = quantity;
            Customer = customer;
            State = state;
        }
    }

    public class State
    {
        public State(state currrentState, DateTime dateTime)
        {
            this.CurrrentState = currrentState;
            this.dateTime = dateTime;
        }

        public enum state
        {
            Waiting, Dispatched, WaitingDispatch
        }

        public state CurrrentState { get; private set; }
        public DateTime dateTime { get; private set; }
    }
}
