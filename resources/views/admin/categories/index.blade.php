@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">List Categories</h1>
    <div class="row">
        <div class="col">
            <table data-toggle="table" id="category_table" class="table-bordered table">
                <thead>
                    <th width="100">ID</th>
                    <th>Name</th>
                    <th width="200">Actions</th>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr @if($category->trashed()) class="table-warning" @endif>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            <td>
                                <a data-toggle="tooltip" title="Edit category" href="{{ route('categories.edit', ['category' => $category]) }}" class="btn btn-sm btn-info mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($category->trashed())
                                    <a data-toggle="tooltip" title="Restore category" href="javascript:void(0);" onclick="restoreCategory('{{ route('categories.restore', ['category' => $category]) }}');" class="btn btn-sm btn-secondary mr-2">
                                        <i class="fas fa-folder-plus"></i>
                                    </a>
                                    <a data-toggle="tooltip" title="Permanently delete category" onclick="destroyCategory('{{ route('categories.force-delete', ['category' => $category]) }}')" href="javascript:void(0);" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @else
                                    <a data-toggle="tooltip" title="Archive this category" onclick="trashCategory('{{ route('categories.destroy', ['category' => $category]) }}')" href="javascript:void(0);" class="btn btn-sm btn-danger">
                                        <i class="fas fa-folder-minus"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('admin/partials/category_modals')
@endsection
