<section>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sidebar Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 mt-3">
            <div class="list-group list-group-flush">

                <div class="list-group-item py-3">
                    <a class="text-decoration-none fw-bold" href="/home" role="button" aria-expanded="false"
                        aria-controls="menuAdmin">Home
                    </a>
                </div>

                <div class="list-group-item py-3">
                    <a class="text-decoration-none fw-bold" data-bs-toggle="collapse" href="#menuAdmin" role="button"
                        aria-expanded="false" aria-controls="menuAdmin">Manajemen
                    </a>
                </div>

                <div class="collapse multi-collapse list-group-flush show"
                    id="menuAdmin">
                    <a href="/admin/users" class="text-decoration-none list-group-item {{ Route::is('admin.users.list') ? 'active' : '' }}" role="button">Manajemen User</a>
                    <a href="/admin/books" class="text-decoration-none list-group-item {{ Route::is('admin.books.index') ? 'active' : '' }}" role="button">Manajemen Buku</a>
                    <a href="/admin/categories" class="text-decoration-none list-group-item {{ Route::is('admin.categories.index') ? 'active' : '' }}" role="button">Manajemen Kategori</a>
                    <li class="list-group-item {{ Route::is('') ? 'active' : '' }} border-bottom" role="button">Manajeman Peminjaman</li>
                </div>
            </div>
        </div>
    </div>
</section>
