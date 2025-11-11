@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Edit User</h2>
    <a href="{{ route('admin.users.index') }}"
       class="text-sm text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
       ← Back to Users
    </a>
  </div>

  <form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf 
    @method('PUT')

    <!-- Name -->
    <div class="mb-5">
      <label class="block text-gray-700 dark:text-gray-300 mb-1">Name</label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
      @error('name') 
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
      @enderror
    </div>

    <!-- Email -->
    <div class="mb-5">
      <label class="block text-gray-700 dark:text-gray-300 mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
      @error('email') 
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
      @enderror
    </div>

    <!-- Role -->
    <div class="mb-6">
      <label class="block text-gray-700 dark:text-gray-300 mb-1">Role</label>
      <select name="role"
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
        @php
            $roles = ['user' => 'User', 'admin' => 'Admin', 'blogger' => 'Blogger'];
        @endphp
        @foreach($roles as $value => $label)
            <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
      </select>
      @error('role') 
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
      @enderror
    </div>

    <div class="flex justify-end">
      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
        Save Changes
      </button>
    </div>
  </form>
</div>
@endsection
