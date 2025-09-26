<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">{{ request()->routeIs('admin.*') ? 'Dashboard' : 'Account Settings' }}</li>
            </ol>
        </nav>
    </div>
</div>