<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\donor_list.blade.php -->
@extends('layouts.layout')

@section('title', 'Donor List') <!-- Updated title name -->

@section('public_content') <!-- Updated section name -->


      <h2 class="pricing_taital">Blood Donor List</h2>
      <div class="col-12 d-flex justify-content-center my-3">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control text-center" placeholder="Search Donors by Name or ID">
        </div>
    </div>
    <div class="container mt-12">
      

    <!-- Table -->
    <table id="donorTable" class="table table-bordered table-hover">
      <thead class="thead-light">
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Age</th>
          <th>Blood Type</th>
          <th>Location</th>
          <th>Last Donated</th>
          <th>SSC Batch</th>
          <th>Times Donated</th> <!-- New Column Added -->
          <th>Contact</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>001</td>
          <td>Alex Green</td>
          <td>29</td>
          <td>O+</td>
          <td>Miami</td>
          <td>02/05/2025</td>
          <td>2012</td>
          <td>5</td> <!-- Added Times Donated -->
          <td>
            <a href="login.html" class="btn btn-outline-primary btn-sm">
              <i class="fas fa-phone-alt"></i> Call
            </a>
          </td>
          <td><a href="mailto:alex.green@email.com">alex.green@email.com</a></td>
        </tr>
        <tr>
          <td>002</td>
          <td>Sophia Black</td>
          <td>25</td>
          <td>A-</td>
          <td>Los Angeles</td>
          <td>01/20/2025</td>
          <td>2016</td>
          <td>3</td> <!-- Added Times Donated -->
          <td>
            <a href="login.html" class="btn btn-outline-primary btn-sm">
              <i class="fas fa-phone-alt"></i> Call
            </a>
          </td>
          <td><a href="mailto:sophia.black@email.com">sophia.black@email.com</a></td>
        </tr>
        <tr>
          <td>003</td>
          <td>Michael White</td>
          <td>38</td>
          <td>B+</td>
          <td>Chicago</td>
          <td>12/12/2024</td>
          <td>2005</td>
          <td>7</td> <!-- Added Times Donated -->
          <td>
            <a href="login.html" class="btn btn-outline-primary btn-sm">
              <i class="fas fa-phone-alt"></i> Call
            </a>
          </td>
          <td><a href="mailto:michael.white@email.com">michael.white@email.com</a></td>
        </tr>
        <tr>
          <td>004</td>
          <td>Olivia Brown</td>
          <td>33</td>
          <td>AB-</td>
          <td>Dallas</td>
          <td>02/10/2025</td>
          <td>2010</td>
          <td>0</td> <!-- Added Times Donated -->
          <td>
            <a href="login.html" class="btn btn-outline-primary btn-sm">
              <i class="fas fa-phone-alt"></i> Call
            </a>
          </td>
          <td><a href="mailto:olivia.brown@email.com">olivia.brown@email.com</a></td>
        </tr>
        <tr>
          <td>005</td>
          <td>James Red</td>
          <td>45</td>
          <td>O-</td>
          <td>Houston</td>
          <td>11/30/2024</td>
          <td>1997</td>
          <td>10</td> <!-- Added Times Donated -->
          <td>
            <a href="login.html" class="btn btn-outline-primary btn-sm">
              <i class="fas fa-phone-alt"></i> Call
            </a>
          </td>
          <td><a href="mailto:james.red@email.com">james.red@email.com</a></td>
        </tr>
      </tbody>
    </table>
    
  </div>

     
  @endsection


@push('scripts') <!-- Updated section name -->
        <!-- Scripts -->
    <script>
    $(document).ready(function() {
      // Initialize DataTable with Search, Sort, and Pagination
      var table = $('#donorTable').DataTable({
        searchPanes: {
          cascadePanes: true
        }
      });

      // Add search functionality
      $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
      });
    });
  </script>

      <script>
         // Material Select Initialization
         $(document).ready(function() {
         $('.mdb-select').materialSelect();
         $('.select-wrapper.md-form.md-outline input.select-dropdown').bind('focus blur', function () {
         $(this).closest('.select-outline').find('label').toggleClass('active');
         $(this).closest('.select-outline').find('.caret').toggleClass('active');
         });
         });
      </script>
@endpush