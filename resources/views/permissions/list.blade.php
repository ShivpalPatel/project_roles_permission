<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
        @can('create permissions')
        <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md
         text-white px-3 py-2">Create</a>
         @endCan
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left"  width=60 >#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left" width=180>Created</th>
                        <th class="px-6 py-3 text-center" width=180>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($permissions->isNotEmpty())
                    @foreach ($permissions as $permission)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $permission->id }}</td>
                        <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                        <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse( $permission->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-3 text-center">
                            @can('update permissions')
                            <a href="{{route('permissions.edit',$permission->id)}}" class="bg-slate-700 text-sm rounded-md
                            text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                            @endcan
                            {{-- <a href="javascript:void(0)" onclick="deletePermission({{$permission->id}})" class="bg-red-600 text-sm rounded-md
                            text-white px-3 py-2 hover:bg-red-500">Delete</a> --}}
                            {{-- <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-sm rounded-md
                                 text-white px-3 py-2 hover:bg-red-500">
                                    Delete
                                </button>
                            </form> --}}
                            @can('delete permissions')
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this permission?');">
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
            <div class="my-3">
                {{$permissions->links()}}
            </div>

        </div>
    </div>
    {{-- <x-slot name="script">
        <script type="text/javascript">
           function deletePermission(id){
                if(confirm("Are you sure you want to delete?")){
                    $.ajax{
                        url:'{{ route("permissions.destroy")}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response){ // call back fn
                                window.location.href = '{{route("permissions.index")}}';
                        }
                    }
                }
           }
        </script>
    </x-slot> --}}
</x-app-layout>