<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
        @can('create roles')
        <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md
         text-white px-3 py-2">Create</a>
         @endCan
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
          {{-- creating  table --}}
          <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class="px-6 py-3 text-left"  width=60 >#</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Permissions</th>
                    <th class="px-6 py-3 text-left" width=180>Created</th>
                    <th class="px-6 py-3 text-center" width=180>Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if($roles->isNotEmpty())
                @foreach ($roles as $role)
                <tr class="border-b">
                    <td class="px-6 py-3 text-left">{{ $role->id }}</td>
                    <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                    <td class="px-6 py-3 text-left">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse( $role->created_at)->format('d M, Y') }}</td>
                    <td class="px-6 py-3 text-center">
                        @can('update roles')
                        <a href="{{route('roles.edit',$role->id)}}" class="bg-slate-700 text-sm rounded-md
                            text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                           @endcan

                           @can('delete roles')
                           <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">
                                    Delete
                                </button>
                            </form>
                            @endcan
                    </td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>
          {{-- creating  table --}}
            <div class="my-3">
                {{$roles->links()}}
            </div>

        </div>
    </div>

</x-app-layout>
