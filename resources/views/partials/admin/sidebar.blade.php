<div class="position-fixed top-0 start-0 text-black d-flex flex-column justify-between"
     style="width: 16rem; height: 100vh; padding-top: 4rem; background-color: #FFEB3B;">


    <a href="/profile" class="text-decoration-none text-dark">
        <div class="d-flex align-items-center gap-3 p-3 hover-effect flex-wrap" style="min-width: 0;">
        {{-- <div class="d-flex align-items-center gap-3 p-3 hover-effect"> --}}
            <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets/avatar.png') }}" 
                 class="rounded-circle object-fit-cover" 
                 style="width: 3rem; height: 3rem; aspect-ratio: 1 / 1;" 
                 alt="User">
            <div class="text-break" style="min-width: 0; max-width: 9rem;">
                <p class="fw-bold mb-0">{{ Auth::user()->name }}</p>
                <p class="text-sm mb-0">{{ Auth::user()->email }}</p>
            </div>
        </div>        
    </a>

    <nav class="flex-grow-1 mt-4 d-flex flex-column gap-3">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-3 py-2 px-3 text-decoration-none text-dark hover-effect">
            <img src="{{ asset('assets/dashboard.png') }}" alt="Dashboard" style="width: 1.5rem; height: 1.5rem;">
            <span>Dashboard</span>
        </a>
        <a href="/kelolarapat" class="d-flex align-items-center gap-3 py-2 px-3 text-decoration-none text-dark hover-effect">
            <img src="{{ asset('assets/undangan.png') }}" alt="undangan" style="width: 1.5rem; height: 1.5rem;">
            <span>Kelola Rapat</span>
        </a>
        <a href="/kelolauser" class="d-flex align-items-center gap-3 py-2 px-3 text-decoration-none text-dark hover-effect">
            <img src="{{ asset('assets/adduser.png') }}" alt="add user" style="width: 1.5rem; height: 1.5rem;">
            <span>Kelola Pengguna</span>
        </a>
    </nav>
    <form action="{{ route('logout') }}" method="POST" class="d-flex align-items-center gap-2 py-2 px-3 mb-3">
        @csrf
        <button type="submit" class="btn p-0 border-0 bg-transparent d-flex align-items-center text-dark hover-effect">
            <img src="{{ asset('assets/logout.png') }}" alt="logout" style="width: 1.5rem; height: 1.5rem;">
            <span class="ms-2">Logout</span>
        </button>
    </form>
</div>