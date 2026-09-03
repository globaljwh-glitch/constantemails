@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="borderBottom">
        <h2>Edit Contact</h2>
    </div>

    <p class="mt-4">
        Update contact information.
    </p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('user.contacts.update',$contact) }}">

        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-lg-3">
                <strong>Contact Group</strong>
            </div>

            <div class="col-lg-6">

                <select name="group_id"
                        class="form-control"
                        required>

                    @foreach($groups as $group)

                        <option value="{{ $group->id }}"
                            {{ old('group_id',$contact->group_id)==$group->id?'selected':'' }}>

                            {{ $group->group_name }}

                        </option>

                    @endforeach

                </select>

            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>First Name</strong></div>
            <div class="col-lg-6">
                <input type="text"
                       name="contact_first_name"
                       class="form-control"
                       value="{{ old('contact_first_name',$contact->contact_first_name) }}"
                       required>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Last Name</strong></div>
            <div class="col-lg-6">
                <input type="text"
                       name="contact_last_name"
                       class="form-control"
                       value="{{ old('contact_last_name',$contact->contact_last_name) }}">
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Email</strong></div>
            <div class="col-lg-6">
                <input type="email"
                       name="contact_email"
                       class="form-control"
                       value="{{ old('contact_email',$contact->contact_email) }}"
                       required>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Phone</strong></div>
            <div class="col-lg-6">
                <input type="text"
                       name="contact_phone"
                       class="form-control"
                       value="{{ old('contact_phone',$contact->contact_phone) }}">
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Company</strong></div>
            <div class="col-lg-6">
                <input type="text"
                       name="contact_company_name"
                       class="form-control"
                       value="{{ old('contact_company_name',$contact->contact_company_name) }}">
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Address</strong></div>
            <div class="col-lg-6">
                <textarea name="contact_address"
                          class="form-control"
                          rows="3">{{ old('contact_address',$contact->contact_address) }}</textarea>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-3"><strong>Area of Interest</strong></div>
            <div class="col-lg-6">
                <input type="text"
                       name="area_interest"
                       class="form-control"
                       value="{{ old('area_interest',$contact->area_interest) }}">
            </div>
        </div>

        <button class="submitButton">
            Update Contact
        </button>

    </form>

</div>

@endsection