import React from 'react';

var sha256 = require('js-sha256').sha256;

let env = process.env.REACT_APP_BUILD_TYPE;

class PaymentButton extends React.Component {
  jsonToQueryString = json => {
    return (
      '?' +
      Object.keys(json)
        .map(function (key) {
          return encodeURIComponent(key) + '=' + encodeURIComponent(json[key]);
        })
        .join('&')
    );
  };

  handlePayment = async payload => {
    payload.orderId = this.orderId;
    payload.transactionAmount = payload.transactionAmount.split(',').join('');
    payload.redirectUrl = window.location.origin + window.location.pathname;
    payload.env = env;
    var queryString = this.jsonToQueryString(payload);

    if (env === 'app') {
      let ref = window.open(
        `<YOUR URL>/paymentRedirect.php${queryString}`,
        '_blank',
        'location=no'
      );
      ref.addEventListener('loadstart', e => {
        if (e.url === `<YOUR URL>/SUCCESS_paytm.php`) {
          this.props.onPaymentSubmit(this.orderId, 'success', 'paytm');
          ref.close();
        } else if (e.url === `<YOUR URL>/FAILURE_paytm.php`) {
          this.props.onPaymentSubmit(this.orderId, 'failure', 'paytm');
          ref.close();
        } else if (e.url === `<YOUR URL>/SUCCESS_payu.php`) {
          this.props.onPaymentSubmit(this.orderId, 'success', 'payu');
          ref.close();
        } else if (e.url === `<YOUR URL>/FAILURE_payu.php`) {
          this.props.onPaymentSubmit(this.orderId, 'failure', 'payu');
          ref.close();
        }
      });
    } else {
      window.open(
        `<YOUR URL>/paymentRedirect.php${queryString}`,
        '_self',
        'location=no'
      );
    }
  };

  onhandleSubmit = async event => {
    event.preventDefault();
    var random = Math.floor(1000000000 + Math.random() * 9000000000);
    let shaRandom = sha256(random.toString()).substring(0, 25);
    this.orderId = shaRandom;
    let payload = JSON.parse(JSON.stringify(this.props.payload));
    this.handlePayment(payload);
  };

  render() {
    const { buttonText } = this.props;
    // console.log(JSON.stringify(this.props.payload))
    return (
      <button type='submit' onClick={this.onhandleSubmit}>
        {buttonText}
      </button>
    );
  }
}

export default PaymentButton;
