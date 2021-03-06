<?php

namespace Kinedu\PaymentGateways\Stripe\Connect;

use Exception;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Stripe\Account as StripeAccount;
use Kinedu\PaymentGateways\Util\Util;
use Kinedu\PaymentGateways\ApiResource;

class Account extends ApiResource
{
    /** @var string */
    const OBJECT_NAME = 'account';

    /**
     * Create a new connect account.
     *
     * @param  array  $data
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\Connect\Account
     */
    public static function create(array $data)
    {
        if (! Arr::get($data, 'requested_capabilities')) {
            throw new InvalidArgumentException('Requested capabilities is required.');
        }

        try {
            $account = StripeAccount::create(array_merge($data, [
                'type' => 'custom',
            ]));
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($account);
    }

    /**
     * Return the account for the given ID.
     *
     * @param  string  $accountId
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\Connect\Account
     */
    public static function find(string $accountId)
    {
        try {
            $account = StripeAccount::retrieve($accountId);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($account);
    }

    /**
     * Update the given account ID.
     *
     * @param  string  $accountId
     * @param  array  $account
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\Connect\Account
     */
    public static function update(string $accountId, array $data)
    {
        try {
            $account = StripeAccount::update($accountId, $data);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($account);
    }

    /**
     * Create an external account for the given account ID.
     *
     * @param  string  $accountId
     * @param  array  $account
     *
     * @throws \Exception
     *
     * @return \Kinedu\PaymentGateways\Stripe\Connect\Account
     */
    public static function createExternalAccount(string $accountId, array $data)
    {
        if (! $externalAccount = Arr::get($data, 'external_account')) {
            throw new InvalidArgumentException('External account is required.');
        }

        if (! Arr::get($externalAccount, 'object') ||
            ! Arr::get($externalAccount, 'country') ||
            ! Arr::get($externalAccount, 'currency') ||
            ! Arr::get($externalAccount, 'account_number')) {
            throw new InvalidArgumentException('object, country, currency and account_number are required in external_account.');
        }

        try {
            $account = StripeAccount::createExternalAccount($accountId, $data);
        } catch (Exception $e) {
            throw $e;
        }

        return Util::convertToObject($account);
    }
}
