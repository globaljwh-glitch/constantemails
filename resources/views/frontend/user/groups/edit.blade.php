@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="borderBottom">
        <h2>Edit Contact Group</h2>
    </div>

    <p class="mt-4">
        Categorizing your Contact Groups helps maintain them in an organized manner.
    </p>

    <div class="accountInfo">

        <form method="POST" action="{{ route('user.groups.update', $group) }}">

            @csrf
            @method('PUT')

            <div class="row mb-3">

                <div class="col-lg-3">
                    <strong>Category</strong>
                </div>

                <div class="col-lg-6">

                    <select name="category_id" class="form-control" required>

                        <option value="">Select Category</option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id', $group->category_id) == $category->id ? 'selected' : '' }}>

                                {{ $category->category_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-lg-3">
                    <strong>Group Name</strong>
                </div>

                <div class="col-lg-6">

                    <input
                        type="text"
                        name="group_name"
                        class="form-control"
                        value="{{ old('group_name', $group->group_name) }}"
                        required
                    >

                </div>

            </div>

            <button type="submit" class="submitButton">
                Update Group
            </button>

        </form>

    </div>

</div>

@endsection