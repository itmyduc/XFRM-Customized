<?php
/**
 * @license
 * Copyright 2018 TruongLuu. All Rights Reserved.
 */

namespace Truonglv\XFRMCustomized;

use XF\Template\Templater;

class Callback
{
    public static function renderPaymentProfiles($value, array $params, Templater $templater)
    {
        if (empty($params['resource'])) {
            throw new \InvalidArgumentException('Missing resource data in callback.');
        }

        /** @var \Truonglv\XFRMCustomized\XFRM\Entity\ResourceItem $resource */
        $resource = $params['resource'];

        /** @var \XF\Repository\Payment $paymentRepo */
        $paymentRepo = \XF::repository('XF:Payment');

        $controlOptions = [
            'name' => 'payment_profile_ids'
        ];

        $choices = [];
        /** @var \XF\Entity\PaymentProfile $paymentProfile */
        foreach ($paymentRepo->findPaymentProfilesForList()->fetch() as $paymentProfile) {
            $choices[] = [
                'value' => $paymentProfile->payment_profile_id,
                'label' => $paymentProfile->title,
                'selected' => in_array($paymentProfile->payment_profile_id, $resource->payment_profile_ids)
            ];
        }

        $rowOptions = [
            'label' => \XF::phrase('payment_profiles')
        ];

        return $templater->formCheckBoxRow($controlOptions, $choices, $rowOptions);
    }
}
