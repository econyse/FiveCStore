@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('mssg') !== null)
            <div class="alert alert-{{ session('alerttype')}} alert-dismissible fade show" role="alert">
                {{ session('mssg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="card col-md-12">
                <div class="card-body">
                    <h3 class="card-title">New category</h3>
                    <form action="{{ route('createCategory') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="card-link btn btn-success">Add Category</button>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $category->category }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <a href="javascript:EditModal('{{ $category->_id }}','{{ $category->category }}','{{ $category->description }}')">Edit</a> |
                                    <a href="javascript:DeleteModal('{{ $category->_id }}', '{{ $category->category }}')">Delete</a> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm" action="{{ route('editCategory', [ 'id' => 1 ]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="editcategory">Category</label>
                                <input type="text" name="editcategory" id="editcategory" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="editdescription">Description</label>
                                <textarea name="editdescription" id="editdescription" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Edit Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Delete -->
        <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deleteCategoryForm" action="{{ route('deleteCategory', [ 'id' => 1 ]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <p>
                                Are you sure you want to delete <span id="deletecategory"></span> category.
                            </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function EditModal(id, category, description) {
            var elEditForm = document.getElementById("editCategoryForm");
            var inCategory = elEditForm.querySelector("#editcategory");
            var inDescription = elEditForm.querySelector("#editdescription");

            inCategory.value = category;
            inDescription.innerHTML = description;
            var actionURL = elEditForm.getAttribute("action");
            // actionURL = actionURL.slice(0, actionURL.length - 1) + id;
            actionURL = actionURL.slice(0, actionURL.lastIndexOf("/") + 1) + id;
            elEditForm.setAttribute("action", actionURL);

            $("#editCategoryModal").modal("show");

        }

        function DeleteModal(id, category) {
            var elDeleteForm = document.getElementById("deleteCategoryForm");
            var spCategory = elDeleteForm.querySelector("#deletecategory");

            spCategory.innerHTML = category;
            var actionURL = elDeleteForm.getAttribute("action");
            actionURL = actionURL.slice(0, actionURL.lastIndexOf("/") + 1) + id;
            elDeleteForm.setAttribute("action", actionURL);

            $("#deleteCategoryModal").modal("show");
        }
    </script>
@endsection
