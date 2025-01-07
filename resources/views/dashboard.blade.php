@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between align-items-center">
            <h1 class="my-4">Dashboard</h1>
            <a href="{{ route('logout') }}" class="btn btn-danger "><i class="fa fa-sign-out"></i> Logout</a>
        </div>
        <hr class="mt-0">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class=" row mb-1 "> 
            <div class="col-md-6">
                <h5>Import or Export Students</h5>
                <form action="{{route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2 mr-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mr-3"><i class="fa fa-upload"></i> Upload</button>
                        <a href="{{ route('students.export') }}" class="btn btn-success mt-4"><i class="fa fa-download"></i> Export</a>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h5>Certificates</h5>

                <form action="{{ route('students.certificates') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <p class="mb-1">You can generate certificates here.</p>
                        <button type="submit" class="btn btn-success mt-0"><i class="fa fa-file-pdf-o"></i> Generate Certificates</button>                        
                    </div>
                </form>
            </div>
        </div>
        <hr class="mt-0">

        <form method="POST" action="{{ route('dashboard') }}">
            @csrf
            <div class="mb-3">
                <h5>Manage Students</h5>
                <label for="name" class="form-label">Student Name</label>
                <div class="d-flex">
                    <input type="text" name="name" id="name" class="form-control mr-3" placeholder="Enter Student Name" required>
                    <button type="submit" class="btn btn-primary pl-4 pr-4">Add </button>
                </div>
            </div>
        </form>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>
                            <input type="number" class="form-control grade-input" maxlength="3" 
                                oninput="this.value = this.value.slice(0, 3)" 
                                data-id="{{ $student->id }}" value="{{ $student->grade }}">
                        </td>
                        <td class="remarks-cell text-center" style="{{ $student->grade >= 60 ? 'background-color: #5cb85c; color: white;' : 'background-color: #d9534f; color: white;' }}">
                            {{ $student->grade >= 60 ? 'PASSED' : 'FAILED' }}
                        </td>
                        <td>
                            <button class="btn btn-danger delete-student" data-id="{{ $student->id }}"><i class="fa fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.grade-input').forEach(input => {
            input.addEventListener('change', function () {
                const id = this.dataset.id;
                const grade = this.value;
                const remarksCell = this.closest('tr').querySelector('.remarks-cell');
                
                let remarks = '';
                if (grade >= 60) {
                    remarks = 'PASSED';
                    remarksCell.style.backgroundColor = '#5cb85c';
                    remarksCell.style.color = 'white';
                } else {
                    remarks = 'FAILED';
                    remarksCell.style.backgroundColor = '#d9534f';
                    remarksCell.style.color = 'white';
                }

                remarksCell.textContent = remarks;
                fetch(`/students/${id}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ grade }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Grade updated successfully');
                    }
                });
            });
        });
        document.querySelectorAll('.delete-student').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                if (confirm('Are you sure you want to delete this student?')) {
                    fetch(`/students/${id}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Student deleted successfully');
                            this.closest('tr').remove();
                        }
                    });
                }
            });
        });
        @if(session('success') || session('error'))
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 2000);
        @endif

    </script>
@endsection
