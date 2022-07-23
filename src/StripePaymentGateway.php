<?php

namespace Kinedu\PaymentGateways;

use Exception;
use Stripe\Stripe;
use Kinedu\PaymentGateways\Traits\HasServices;
use Kinedu\PaymentGateways\Stripe\{
    Card as StripeCard,
    Charge as StripeCharge,
    Customer as StripeCustomer,
    PaymentIntent as StripePaymentIntent,
    Token as StripeToken
};

class StripePaymentGateway implements PaymentGateway
{
    use HasServices;

    public function __construct(string $apiKey)
    {
        Stripe::setApiKey($apiKey);
    }

    /**
     * Return a collection of customers from Stripe.
     *
     * @param  array  $params
     *
     * @throws \Exception
     */
    public function getAllCustomers(array $params = [])
    {
        throw new Exception('This feature is not currently supported.');
    }

    /**
     * Create a new customer.
     *
     * @param  array  $data  The customer information to be stored.
     *
     * @return \Kinedu\PaymentGateways\Stripe\Customer
     */
    public function createCustomer(array $data)
    {
        return StripeCustomer::create($data);
    }

    /**
     * Get the given token.
     *
     * @param  string  $token
     *
     * @return \Kinedu\PaymentGateways\Stripe\Token
     */
    public function getToken(string $token)
    {
        return StripeToken::get($token);
    }

    /**
     * Add a new customer card.
     *
     * @param  string  $customerId
     * @param  string  $token
     *
     * @return \Kinedu\PaymentGateways\Stripe\Card
     */
    public function addCard(string $customerId, string $token)
    {
        return StripeCard::create($customerId, $token);
    }

    /**
     * Return a listing of all cards belonging to the specified customer.
     *
     * @param  string  $customerId
     *
     * @throws \Exception
     */
    public function getAllCards(string $customerId)
    {
        throw new Exception('This feature is not currently supported.');
    }

    /**
     * Return a collection of all charges made to the customer.
     *
     * @param  array  $params
     *
     * @throws \Exception
     */
    public function getAllCharges(array $params = [])
    {
        throw new Exception('This feature is not currently supported.');
    }

    /**
     * Charge the customer the given amount.
     *
     * @param  float  $amount
     * @param  array  $options
     *
     * @return mixed
     */
    public function charge(float $amount, array $options = [])
    {
        return StripeCharge::create($amount,  $options);
    }

    /**
     * Return the operation with the given transaction ID.
     *
     * @param  string  $transactionId
     *
     * @return \Kinedu\PaymentGateways\Stripe\Charge
     */
    public function getOperation(string $transactionId)
    {
        return StripeCharge::find($transactionId);
    }

    /**
     * Create a new payment intent.
     *
     * @param  array  $data
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public function createPaymentIntent(array $data)
    {
        return StripePaymentIntent::create($data);
    }

    /**
     * Confirm a payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $data
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public function confirmPaymentIntent(string $paymentIntentId, array $data)
    {
        return StripePaymentIntent::confirm($paymentIntentId, $data);
    }

    /**
     * Cancel a payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $data
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public function cancelPaymentIntent(string $paymentIntentId, array $data = [])
    {
        return StripePaymentIntent::cancel($paymentIntentId, $data);
    }

    /**
     * Return the name of the current payment provider.
     *
     * @return string
     */
    public function getProviderName(): string
    {
        return 'Stripe';
    }
}
