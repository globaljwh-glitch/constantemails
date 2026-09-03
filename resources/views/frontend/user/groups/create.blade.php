@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="borderBottom">
        <h2>Add Contact Group</h2>
    </div>

    <p class="mt-4">
        Categorizing your Contact Groups helps maintain them in an organized manner.
    </p>

    <div class="accountInfo">

        <form method="POST" action="{{ route('user.groups.store') }}">

            @csrf

            <div class="row mb-3">

                <div class="col-lg-3">
                    <strong>Category</strong>
                </div>

                <div class="col-lg-6">

                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
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
                        value="{{ old('name') }}"
                    >

                </div>

            </div>

            <button class="submitButton">

                Save Group

            </button>

        </form>

    </div>

</div>

@endsection