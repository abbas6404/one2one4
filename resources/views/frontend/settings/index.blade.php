@extends('frontend.layouts.frontend')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings</h1>
    </div>

    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="list-group list-group-flush">
                    <a href="#account" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                        <i class="fas fa-user me-2"></i> Account Settings
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-bell me-2"></i> Notifications
                    </a>
                    <a href="#privacy" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-lock me-2"></i> Privacy & Security
                    </a>
                    <a href="#preferences" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-cog me-2"></i> Preferences
                    </a>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Account Settings -->
                <div class="tab-pane fade show active" id="account">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Account Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" value="{{ auth()->user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="phone" value="{{ auth()->user()->contact_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" rows="3"></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Notification Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="mb-3">Email Notifications</h6>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="emailAppointments" checked>
                                    <label class="form-check-label" for="emailAppointments">Appointment Reminders</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="emailDonations" checked>
                                    <label class="form-check-label" for="emailDonations">Donation Updates</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNewsletter">
                                    <label class="form-check-label" for="emailNewsletter">Newsletter</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h6 class="mb-3">Push Notifications</h6>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushAppointments" checked>
                                    <label class="form-check-label" for="pushAppointments">Appointment Alerts</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="pushUrgent" checked>
                                    <label class="form-check-label" for="pushUrgent">Urgent Blood Requests</label>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">Save Preferences</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="tab-pane fade" id="privacy">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Privacy & Security</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="mb-3">Account Security</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">Two-Factor Authentication</h6>
                                        <small class="text-muted">Add an extra layer of security to your account</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="twoFactor">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Login Notifications</h6>
                                        <small class="text-muted">Get notified when someone logs into your account</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="loginNotifications" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h6 class="mb-3">Data Privacy</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="showProfile" checked>
                                    <label class="form-check-label" for="showProfile">
                                        Show my profile in donor search
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="shareData">
                                    <label class="form-check-label" for="shareData">
                                        Share my donation history with blood banks
                                    </label>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">Save Settings</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="tab-pane fade" id="preferences">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="mb-3">Language</h6>
                                <select class="form-select">
                                    <option selected>English</option>
                                    <option>Spanish</option>
                                    <option>French</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <h6 class="mb-3">Time Zone</h6>
                                <select class="form-select">
                                    <option selected>(GMT+00:00) London</option>
                                    <option>(GMT+01:00) Paris</option>
                                    <option>(GMT+02:00) Athens</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <h6 class="mb-3">Theme</h6>
                                <div class="d-flex gap-3">
                                    <button class="btn btn-outline-primary active">Light</button>
                                    <button class="btn btn-outline-primary">Dark</button>
                                    <button class="btn btn-outline-primary">System</button>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">Save Preferences</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.list-group-item {
    border-left: none;
    border-right: none;
    padding: 1rem;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}

.list-group-item.active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
}

.form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}
</style>
@endpush
@endsection 