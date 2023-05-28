<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/site/index" class="brand-link">

        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'РОЗДІЛИ САЙТУ', 'header' => true],
                    ['label' => 'Магазини', 'iconStyle' => 'far', 'icon' => 'circle', 'url' => ['/food/shop'], 'active' => $this->context->id == 'food/shop'],
                    ['label' => 'Їжа', 'iconStyle' => 'far', 'icon' => 'circle', 'url' => ['/food/food'], 'active' => $this->context->id == 'food/food'],
                    ['label' => 'Замовлення', 'iconStyle' => 'far', 'icon' => 'circle', 'url' => ['/food/order'], 'active' => $this->context->id == 'food/order'],
                    ['label' => 'Користувочі', 'iconStyle' => 'fa', 'icon' => 'users', 'url' => ['/user'], 'active' => $this->context->id == 'user'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>