<?php

namespace Kinedu\PaymentGateways\Stripe;

use Exception;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Kinedu\PaymentGateways\Util\Util;
use Kinedu\PaymentGateways\ApiResource;
use Stripe\PaymentIntent as StripePaymentIntent;

class PaymentIntent extends ApiResource
{
    /** @var string */
    const OBJECT_NAME = 'payment_intent';

    /**
     * Create a new payment intent.
     *
     * @param  array  $data
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public static function create(array $data)
    {
        if (! Arr::get($data, 'amount')) {
            throw new InvalidArgumentException('Amount is required.');
        }

        if (! Arr::get($data, 'currency')) {
            throw new InvalidArgumentException('Currency is required.');
        }

        try {
            $paymentIntent = StripePaymentIntent::create($data);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($paymentIntent);
    }

    /**
     * Return the given payment intent id
     *
     * @param  string  $paymentIntentId
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public static function get(string $paymentIntentId)
    {
        try {
            $paymentIntent = StripePaymentIntent::retrieve($paymentIntentId);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($paymentIntent);
    }

    /**
     * Cancel the given payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $data
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public static function cancel(string $paymentIntentId, array $data = [])
    {
        try {
            $paymentIntent = self::get($paymentIntentId)->cancel($data);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($paymentIntent);
    }

    /**
     * Confirm the given payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $data
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\PaymentIntent
     */
    public static function confirm(string $paymentIntentId, array $data)
    {
        try {
            $paymentIntent = self::get($paymentIntentId)->confirm($data);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($paymentIntent);
    }
}
