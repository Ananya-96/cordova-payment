import React from 'react';
import './App.css';
import PaymentButton from './PaymentButton';
import * as queryString from 'query-string/index';

class App extends React.Component {
  onPaymentSubmit = (orderId, status, paymentProvider) => {
    console.log(orderId, status, paymentProvider);
  };

  componentDidMount() {
    //this gets called when its redirected from the paytmResponse.php for browser
    if (window.location.search) {
      let queryParams = queryString.parse(window.location.search);
      if (queryParams.orderId) {
        this.onPaymentSubmit(
          queryParams.orderId,
          queryParams.status,
          queryParams.paymentProvider
        );
      }
    }
  }
  render() {
    return (
      <div className='App'>
        <PaymentButton
          buttonText={`Pay Now`}
          payload={{
            transactionAmount: '20',
            firstname: 'Ananya',
            phone: '9999999999',
            email: 'test@test.in',
            custId: 'test@test.in'
          }}
          onPaymentSubmit={this.onPaymentSubmit}
        />
      </div>
    );
  }
}

export default App;
