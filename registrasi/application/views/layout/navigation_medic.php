
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item <?= $parent=='checkup'?'active':'' ?>" data-item="checkup">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Doctor"></i>
                    <span class="nav-text">Medical Checkup</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <header class="p-4">
            <div class="logos mb-2 text-center">
                <img src="<?= base_url().'dist-assets/'?>images/logo_namira.png" alt="">
            </div>
        </header>
        <!-- Submenu Dashboards -->

        <div class="submenu-area" data-parent="checkup">
            <header>
                <h6>Medical Checkup</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'medical-checkup'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Hasil Checkup</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>