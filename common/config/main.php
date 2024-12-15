<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queueRequests',
        'queueComments',
        'queueCommentsEmail',
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'queueCommentsEmail' => [
            'class' => \yii\queue\amqp_interop\Queue::class
            , 'driver' => \yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_BUNNY
            , 'port' => 5672
            , 'user' => 'guest'
            , 'password' => 'guest'
            , 'queueName' => 'queue_comment_email'
            , 'exchangeName' => 'exchange_comment'
            , 'dsn' => 'amqp:'
            , 'qosPrefetchSize' => 0
            , 'qosPrefetchCount' => 0
            , 'strictJobType' => false
            , 'serializer' => \yii\queue\serializers\JsonSerializer::class
            , 'as log' => \yii\queue\LogBehavior::class,
        ],
        'queueComments' => [
            'class' => \yii\queue\amqp_interop\Queue::class
            , 'driver' => \yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_BUNNY
            , 'port' => 5672
            , 'user' => 'guest'
            , 'password' => 'guest'
            , 'queueName' => 'queue_comment'
            , 'exchangeName' => 'exchange_comment'
            , 'dsn' => 'amqp:'
            , 'qosPrefetchSize' => 0
            , 'qosPrefetchCount' => 0
            , 'strictJobType' => false
            , 'serializer' => \yii\queue\serializers\JsonSerializer::class
            , 'as log' => \yii\queue\LogBehavior::class,
        ],
        'queueRequests' => [
            'class' => \yii\queue\amqp_interop\Queue::class
            , 'driver' => \yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_BUNNY
            , 'port' => 5672
            , 'user' => 'guest'
            , 'password' => 'guest'
            , 'queueName' => 'queue_request'
            , 'exchangeName' => 'exchange_request'
            , 'dsn' => 'amqp:'
            , 'qosPrefetchSize' => 0
            , 'qosPrefetchCount' => 0
            , 'strictJobType' => false
            , 'serializer' => \yii\queue\serializers\JsonSerializer::class
            , 'as log' => \yii\queue\LogBehavior::class,
        ],
    ],
];
