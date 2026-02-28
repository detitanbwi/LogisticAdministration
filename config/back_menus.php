<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'feather-airplay',
        'url' => 'admin.dashboard',
        'can' => 'view.dashboard',
    ],
    [
        'title' => 'Invoice',
        'can' => ['view.invoice', 'create.invoice'],
        'icon' => 'feather-file-text',
        'children' => [
            [
                'title' => 'Buat Invoice',
                'url' => 'admin.invoice.create',
                'can' => 'create.invoice',
                'active' => ['admin.invoice.create'],
            ],
            [
                'title' => 'Rekapitulasi',
                'url' => 'admin.invoice.index',
                'can' => 'view.invoice',
                'active' => ['admin.invoice.index', 'admin.invoice.edit', 'admin.invoice.show'],
            ],
            [
                'title' => 'Packing List',
                'url' => 'admin.packing-list.index',
                'can' => 'view.container',
            ],
        ]
    ],
    [
        'title' => 'Finance',
        'can' => ['view.finance', 'edit.finance'],
        'icon' => 'feather-credit-card',
        'children' => [
            [
                'title' => 'Rekapitulasi',
                'url' => 'admin.finance.index',
                'can' => 'view.finance',
            ],
            [
                'title' => 'Container Cost',
                'url' => 'admin.container-cost.index',
                'can' => 'view.container',
            ],
        ]
    ],
    [
        'title' => 'Arus Kas',
        'icon' => 'feather-trending-up',
        'can' => ['view.kategori_keuangan', 'create.kategori_keuangan'],
        'children' => [
            [
                'title' => 'Kategori',
                'url' => 'admin.transaksi-kategori.index',
                'can' => 'view.kategori_keuangan',
                'active' => ['admin.transaksi-kategori.index', 'admin.transaksi-kategori.create', 'admin.transaksi-kategori.edit'],
            ],
            [
                'title' => 'Rekening Bank',
                'url' => 'admin.bank-rekening.index',
                'can' => 'view.rekening_bank',
                'active' => ['admin.bank-rekening.index', 'admin.bank-rekening.create', 'admin.bank-rekening.edit'],
            ],
            [
                'title' => 'Transaksi',
                'url' => 'admin.transaksi.index',
                'can' => 'view.transaksi',
                'active' => ['admin.transaksi.index', 'admin.transaksi.create', 'admin.transaksi.edit'],
            ],
            [
                'title' => 'Hutang & Piutang',
                'can' => ['view.hutang', 'view.piutang'],
                'children' => [
                    [
                        'title' => 'Hutang',
                        'url' => 'admin.hutang.index',
                        'can' => 'view.hutang',
                        'active' => ['admin.hutang.index'],
                    ],
                    [
                        'title' => 'Piutang',
                        'url' => 'admin.piutang.index',
                        'can' => 'view.piutang',
                        'active' => ['admin.piutang.index'],
                    ],
                ]
            ],
            [
                'title' => 'Laporan',
                'icon' => 'feather-file-text',
                'url' => 'admin.laporan.index',
                'can' => 'view.laporan',
                'active' => ['admin.laporan.index', 'admin.laporan.print'],
            ],
        ]
    ],
    [
        'title' => 'Master Data',
        'icon' => 'feather-database',
        'can' => ['view.user', 'view.kapal', 'view.tujuan', 'view.customer', 'view.container'],
        'children' => [
            [
                'title' => 'Users',
                'url' => 'admin.users.index',
                'can' => 'view.user',
            ],
            [
                'title' => 'Kapal',
                'url' => 'admin.kapal.index',
                'can' => 'view.kapal',
            ],
            [
                'title' => 'Tujuan',
                'url' => 'admin.tujuan.index',
                'can' => 'view.tujuan',
            ],
            [
                'title' => 'Customer',
                'url' => 'admin.customer.index',
                'can' => 'view.customer',
            ],
        ]
    ],
    [
        'title' => 'Settings',
        'icon' => 'feather-settings',
        'can' => ['view.role', 'view.user'],
        'children' => [
            [
                'title' => 'Roles',
                'url' => 'admin.roles.index',
                'can' => 'view.role',
            ],
        ]
    ],
];
