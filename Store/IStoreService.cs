using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;

namespace Store
{
    // NOTE: You can use the "Rename" command on the "Refactor" menu to change the interface name "IStoreService" in both code and config file together.
    [ServiceContract]
    public interface IStoreService
    {
        [OperationContract]
        [WebInvoke(Method = "GET",
            RequestFormat = WebMessageFormat.Json,
            ResponseFormat = WebMessageFormat.Json,
            BodyStyle = WebMessageBodyStyle.Bare,
            UriTemplate = "api/{id}")]
        string JSONData(string id);
    }
}
