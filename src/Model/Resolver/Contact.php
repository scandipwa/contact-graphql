<?php
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/base-theme
 * @link https://github.com/scandipwa/base-theme
 */

namespace ScandiPWA\ContactGraphQl\Model\Resolver;

use Exception;
use Magento\Contact\Model\Config;
use Magento\Contact\Model\Mail;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use function strpos;

class Contact implements ResolverInterface
{
    /**
     * @var Mail
     */
    private $mail;

    /**
     * @var Config
     */
    private $mailConfig;

    /**
     * Contact constructor.
     *
     * @param Mail $mail
     * @param Config $mailConfig
     */
    public function __construct(Mail $mail, Config  $mailConfig)
    {
        $this->mail = $mail;
        $this->mailConfig = $mailConfig;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!$this->mailConfig->isEnabled()) {
            throw new GraphQlInputException(__("Contact is disabled"));
        }

        $data = [];

        $data['name']       = $args['contact']['name']         ?? '';
        $data['telephone']  = $args['contact']['telephone']    ?? '';
        $data['email']      = $args['contact']['email']        ?? '';
        $data['comment']    = $args['contact']['message']      ?? '';

        try {
            $this->sendEmail($this->validatedParams($data));
            $result = ['message' => __('Your message has been sent and we will contact you ASAP')];
        } catch (Exception $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $result;
    }

    /**
     * Send email
     *
     * @param array $post Post data from contact form
     *
     * @return void
     */
    private function sendEmail(array $post): void
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * Validate input data
     *
     * @param $data
     *
     * @return array
     * @throws LocalizedException
     */
    private function validatedParams($data): array
    {
        if (trim($data['name']) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }

        if (trim($data['comment']) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }

        if (false === filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        return $data;
    }
}
