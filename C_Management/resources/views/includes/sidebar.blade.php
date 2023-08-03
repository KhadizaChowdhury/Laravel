<div class="drawer">
    <input id="my-drawer" type="checkbox" class="drawer-toggle" />
    
    <div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 w-80 h-full bg-base-200 text-base-content">
        <!-- Sidebar content here -->
        <label class="ml-3 mb-3 normal-case text-xl font-bold tracking-tight text-gray-900">Dashboard Menu</label>
        <li><a href="{{ url('/profile') }}">Profile</a></li>
        <li><a href="{{ url('/profile-update') }}">Profile Update</a></li>        
    </ul>
    </div>
</div>