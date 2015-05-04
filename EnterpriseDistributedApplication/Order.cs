using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace EnterpriseDistributedApplication
{
    class Order
    {
        private Book Book { get; set; }
        private int Quantity { get; set; }
        private Customer Customer { get; set; }
        private State State { get; set; }
        public Order(Book book, int quantity, Customer customer, State state)
        {
            Book = book;
            Quantity = quantity;
            Customer = customer;
            State = state;
        }
    }

    class State
    {
        public State(state currrentState, DateTime dateTime)
        {
            this.CurrrentState = currrentState;
            this.dateTime = dateTime;
        }
        internal enum state
        {
            Waiting, Dispatched, WaitingDispatch
        }

        public state CurrrentState { get; private set; }
        public DateTime dateTime { get; private set; }
    }
}
