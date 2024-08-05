@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Books</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage books of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/manage/book/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    @php
        $categoryNames = [];
        $categoryIds = [];

        foreach ($book->categories as $category) {
            $categoryNames[] = $category->name;
            $categoryIds[] = $category->id;
        }
    @endphp
    @php
        $oldCategoryIds = [];
        $oldCategoryNames = [];
        if (old('bookCategories')) {
            $temp = explode(',', old('bookCategories'));
            foreach ($temp as $category) {
                $oldCategoryIds[] = $category;
                $oldCategoryNames[] = getCategoryName($category);
            }
        }
    @endphp
    <div class='d-flex w-100 h-100 flex-column' x-data="{
        categoryNames: {{ old('bookCategories') ? json_encode($oldCategoryNames) : json_encode($categoryNames) }},
        categoryIds: {{ old('bookCategories') ? json_encode($oldCategoryIds) : json_encode($categoryIds) }},
        oldCategoryNames: {{ json_encode($categoryNames) }},
        oldCategoryIds: {{ json_encode($categoryIds) }},
        removeFile: {{ old('removeFile') ? 1 : 0 }},
        imageErrorSignal: {{ $errors->has('bookImages') || $errors->has('bookImages.0') ? 1 : 0 }},
        fileErrorSignal: {{ $errors->has('pdfFiles') || $errors->has('pdfFiles.0') || $errors->has('removeFile') ? 1 : 0 }},
        isReset: 0,
    }" id="alpine-data-container"
        @alpine-add-category="categoryNames.push($event.detail.name); categoryIds.push($event.detail.id)"
        @alpine-remove-category="categoryNames = categoryNames.filter((_, index) => index !== categoryIds.indexOf($event.detail.id)); categoryIds = categoryIds.filter(id => id !== $event.detail.id)">
        <form class='block bg-white border border-3 rounded m-auto d-flex flex-column p-3' enctype="multipart/form-data"
            method="POST" action="">
            @csrf
            <div class='w-100 h-100 row'>
                <div class="col-xl-5 col-12">
                    <div class='d-flex flex-column align-items-center w-100 h-100 ps-xl-5 px-3'>
                        <div class="mt-xl-auto my-2 mt-3">
                            <label for="bookNameInput" class="form-label">Book Name:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="text" class="form-control fs-4"
                                @if ($errors->has('bookName')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                id="bookNameInput" name="bookName"
                                value="{{ old('bookName') ? old('bookName') : $book->name }}"
                                data-old-value="{{ $book->name }}" required>
                            @if ($errors->has('bookName'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookName') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-auto my-2 d-flex flex-column w-100 align-items-center">
                            <p class='mb-0 fs-5' id='bookImagePlaceHolder'>Book image<span
                                    class='fw-bold text-danger'>&nbsp;*</span></p>
                            <img class='book-image' id="bookImage" alt="Book image"
                                src="{{ $errors->has('bookImages') || $errors->has('bookImages.0') ? 'https://cdn1.polaris.com/globalassets/pga/accessories/my20-orv-images/no_image_available6.jpg' : route('temporary-url.image', ['path' => $book->image]) }}"
                                data-initial-src="{{ route('temporary-url.image', ['path' => $book->image]) }}">
                            </img>
                            <label
                                class='btn btn-sm btn-light border border-dark mt-3 mx-auto d-flex position-relative justify-content-center {{ $errors->has('bookImages') || $errors->has('bookImages.0') ? 'is-invalid' : '' }}'>
                                <input accept='image/jpeg,image/png' id="imageInput" type='file'
                                    style="opacity: 0; width:1px;" name="bookImages[]" class='position-absolute'
                                    x-on:change="setNewImage(event); imageErrorSignal=0;"></input>
                                <span>Browse</span>
                            </label>
                            @if ($errors->has('bookImages'))
                                <div class="invalid-feedback text-center" x-show="imageErrorSignal === 1">
                                    {{ $errors->first('bookImages') }}
                                </div>
                            @endif
                            @if ($errors->has('bookImages.0'))
                                <div class="invalid-feedback text-center" x-show="imageErrorSignal === 1">
                                    {{ $errors->first('bookImages.0') }}
                                </div>
                            @endif
                            <p id="imageFileName" class='mx-auto mt-2'></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-12">
                    <div class='d-flex flex-column ps-xl-5 w-100 h-100'>
                        <div class="mt-auto mb-2 px-xl-5 px-3">
                            <label for="editionInput" class="form-label">Edition:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="number" class="form-control" id="editionInput" name="bookEdition"
                                value="{{ old('bookEdition') ? old('bookEdition') : $book->edition }}"
                                data-old-value="{{ $book->edition }}" required>
                            @if ($errors->has('bookEdition'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookEdition') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="isbnInput" class="form-label">ISBN-13:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="text" class="form-control"
                                @if ($errors->has('bookIsbn')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                id="isbnInput" name="bookIsbn"
                                value="{{ old('bookIsbn') ? old('bookIsbn') : $book->isbn }}" minlength="13" maxlength="13"
                                pattern="[0-9]{13}" data-old-value="{{ $book->isbn }}" required>
                            @if ($errors->has('bookIsbn'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookIsbn') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="authorInput" class="form-label">Author:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="text" class="form-control" id="authorInput"
                                @if ($errors->has('bookAuthors')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                name="bookAuthors"
                                value="{{ old('bookAuthors') ? implode(', ', explode(',', old('bookAuthors'))) : implode(', ', $book->authors->pluck('name')->toArray()) }}"
                                data-old-value="{{ implode(', ', $book->authors->pluck('name')->toArray()) }}" required>
                            <small class="form-text text-muted">You can enter multiple authors with each
                                seperated by a comma</small>
                            @if ($errors->has('bookAuthors'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookAuthors') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="categoryInput" class="form-label">Category:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <textarea rows="4" x-on:click="new bootstrap.Modal(document.getElementById('categoryModal')).toggle();"
                                class="form-control pointer readonly" id="categoryInput"
                                @if ($errors->has('bookCategories')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                x-bind:value="categoryNames.join('\n')" required style="caret-color: transparent;"></textarea>
                            <textarea rows="1" hidden id="categoryIds" name="bookCategories" x-bind:value="categoryIds"></textarea>
                            @if ($errors->has('bookCategories'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookCategories') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="publisherInput" class="form-label">Publisher:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="text" class="form-control"
                                @if ($errors->has('bookPublisher')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                id="publisherInput" name="bookPublisher"
                                value="{{ old('bookPublisher') ? old('bookPublisher') : $book->publisher }}"
                                data-old-value="{{ $book->publisher }}" required>
                            @if ($errors->has('bookPublisher'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookPublisher') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="publishDateInput" class="form-label">Publish Date:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input type="date" class="form-control"
                                @if ($errors->has('bookPublicationDate')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                id="publishDateInput" name="bookPublicationDate"
                                value="{{ old('bookPublicationDate') ? old('bookPublicationDate') : $book->publication_date }}"
                                data-old-value="{{ $book->publication_date }}" required>
                            @if ($errors->has('bookPublicationDate'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookPublicationDate') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3">
                            <label for="descriptionInput" class="form-label">Description:</label>
                            <textarea rows="5" class="form-control"
                                @if ($errors->has('bookDescription')) x-bind:class="{ 'is-invalid': !isReset }" @endif id="descriptionInput"
                                maxlength='2000' name="bookDescription" data-old-value="{{ $book->description }}">{{ old('bookDescription') ? old('bookDescription') : $book->description }}</textarea>
                            @if ($errors->has('bookDescription'))
                                <div class="invalid-feedback" x-show="!isReset">
                                    {{ $errors->first('bookDescription') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2 px-xl-5 px-3 d-flex flex-md-row flex-column row">
                            <div class='col'>
                                <label for="physicalPriceInput" class="form-label">Hardcover Price
                                    ($):</label>
                                <input step="any" type="number" class="form-control"
                                    @if ($errors->has('physicalPrice')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                    id="physicalPriceInput" placeholder="Enter price" name="physicalPrice"
                                    @if ($book->physicalCopy) value="{{ old('physicalPrice') ? old('physicalPrice') : $book->physicalCopy->price }}"
                                    data-old-value="{{ $book->physicalCopy->price }}" @endif>
                                @if ($errors->has('physicalPrice'))
                                    <div class="invalid-feedback" x-show="!isReset">
                                        {{ $errors->first('physicalPrice') }}
                                    </div>
                                @endif
                            </div>
                            <div class="ms-md-5 mt-2 mt-md-0 col">
                                <label for="inStockInput" class="form-label">In Stock:</label>
                                <input type="number" class="form-control"
                                    @if ($errors->has('physicalQuantity')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                    id="inStockInput" name="physicalQuantity" placeholder="Enter number"
                                    @if ($book->physicalCopy) value="{{ old('physicalQuantity') ? old('physicalQuantity') : $book->physicalCopy->quantity }}"
                                    data-old-value="{{ $book->physicalCopy->quantity }}" @endif>
                                @if ($errors->has('physicalQuantity'))
                                    <div class="invalid-feedback" x-show="!isReset">
                                        {{ $errors->first('physicalQuantity') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-auto mt-2 px-xl-5 px-3 d-flex flex-md-row flex-column row">
                            <div class='col mb-3'>
                                <label for="filePriceInput" class="form-label">E-book
                                    Price ($):</label>
                                <input step="any" type="number" class="form-control"
                                    @if ($errors->has('filePrice')) x-bind:class="{ 'is-invalid': !isReset }" @endif
                                    name="filePrice" id="filePriceInput" placeholder="Enter price"
                                    @if ($book->fileCopy) value="{{ old('filePrice') ? old('filePrice') : $book->fileCopy->price }}"
                                    data-old-value="{{ $book->fileCopy->price }}" @endif>
                                @if ($errors->has('filePrice'))
                                    <div class="invalid-feedback" x-show="!isReset">
                                        {{ $errors->first('filePrice') }}
                                    </div>
                                @endif
                            </div>
                            <div class="ms-md-5 mt-2 mt-md-0 col mb-3">
                                <div class="d-flex flex-column h-100">
                                    <div class="form-label">
                                        <span>
                                            E-book file
                                        </span>
                                        @if ($book->fileCopy)
                                            <span>
                                                &nbsp;(current file
                                                <a id="pdfPath" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    @if ($book->fileCopy->path) data-bs-title="Open PDF file" href="{{ route('temporary-url.pdf', ['path' => $book->fileCopy->path]) }}" alt="PDF file"
                                                    @else data-bs-title="No PDF file" alt="No PDF file" @endif
                                                    target="_blank" aria-label="PDF File">
                                                    <i class="bi bi-file-earmark-fill text-secondary"></i>
                                                </a>
                                                ):
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if ($book->fileCopy && $book->fileCopy->path)
                                            <div class="me-3">
                                                <input
                                                    x-on:change="removeFile = $event.target.checked; setNewFile(null); fileErrorSignal=0;"
                                                    type="checkbox" class="btn-check" id="removeFile" name="removeFile"
                                                    @if (old('removeFile')) checked @endif>
                                                <label class="btn btn-outline-danger btn-sm" for="removeFile">Remove
                                                    file</label>
                                            </div>
                                        @endif
                                        <label class='btn btn-sm btn-light border border-dark' x-show="!removeFile">
                                            <input type="file" class="form-control d-none" id="filePathInput"
                                                name="pdfFiles[]" accept='.pdf'
                                                x-on:change="setNewFile(event); fileErrorSignal=0;">
                                            Browse
                                        </label>
                                    </div>
                                    @if ($errors->has('pdfFiles'))
                                        <div class="invalid-feedback text-center"
                                            x-bind:class="{ 'd-block': fileErrorSignal }">
                                            {{ $errors->first('pdfFiles') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('pdfFiles.0'))
                                        <div class="invalid-feedback text-center"
                                            x-bind:class="{ 'd-block': fileErrorSignal }">
                                            {{ $errors->first('pdfFiles.0') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('removeFile'))
                                        <div class="invalid-feedback text-center"
                                            x-bind:class="{ 'd-block': fileErrorSignal }">
                                            {{ $errors->first('removeFile') }}
                                        </div>
                                    @endif
                                    <p class="mt-1" id="pdfFileName"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class='mb-5 d-flex justify-content-end'>
                <button type="button" class="btn btn-secondary me-2 mb-5 mb-xl-3"
                    x-on:click="setNewImage(null); setNewFile(null); imageErrorSignal=0;
                    fileErrorSignal=0; isReset=1; resetFields();
                    categoryNames=oldCategoryNames; categoryIds=oldCategoryIds;
                    (function() {
                        const checkboxes = document.querySelectorAll(`input[name='category_checkboxes']`);
                        checkboxes.forEach(checkbox=> {
                        checkbox.checked = oldCategoryIds.includes(checkbox.value);
                        });
                    })();">Reset</button>
                <button class="btn btn-primary mb-5 mb-xl-3"
                    x-bind:disabled="imageErrorSignal === 1 || fileErrorSignal === 1">Update</button>
            </div>
        </form>
    </div>

    @livewire('admin.manage.book.category-modal', ['preSelectedCategories' => $categoryIds])

    <div class="modal fade" id="updateSuccess" tabindex="-1" aria-labelledby="Update success modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Book's information updated.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isbnInput = document.getElementById('isbnInput');

            isbnInput.addEventListener('input', function() {
                if (isbnInput.validity.tooShort) {
                    isbnInput.setCustomValidity('The ISBN must be 13 characters long.');
                } else if (isbnInput.validity.patternMismatch) {
                    isbnInput.setCustomValidity('The ISBN must contain only numbers.');
                } else {
                    isbnInput.setCustomValidity('');
                }
            });
        });
    </script>
    <script>
        document.querySelectorAll('.readonly').forEach(element => {
            element.addEventListener('keydown', function(e) {
                if (e.keyCode !== 9) { // ignore tab
                    e.preventDefault();
                }
            });

            element.addEventListener('paste', function(e) {
                e.preventDefault();
            });

            element.addEventListener('focus', function(e) {
                e.preventDefault();
            });

            element.addEventListener('mousedown', function(e) {
                e.preventDefault();
            });
        });
    </script>
    <script>
        window.addEventListener('update-success', event => {
            new bootstrap.Modal(document.getElementById('updateSuccess')).toggle();
        });

        document.getElementById('updateSuccess').addEventListener('hidden.bs.modal', function() {
            window.location.href = '{{ route('admin.manage.book.index') }}';
        });

        window.addEventListener('add-category', event => {
            document.getElementById('alpine-data-container').dispatchEvent(new CustomEvent('alpine-add-category', {
                detail: {
                    id: event.detail.id,
                    name: event.detail.name
                },
                bubbles: true
            }));
        });

        window.addEventListener('remove-category', event => {
            document.getElementById('alpine-data-container').dispatchEvent(new CustomEvent(
                'alpine-remove-category', {
                    detail: {
                        id: event.detail.id,
                        name: event.detail.name
                    },
                    bubbles: true
                }));
        });
    </script>

    <script>
        function setNewImage(e) {
            const file = e ? e.target.files : [];
            document.getElementById('imageFileName').textContent = file.length === 1 ? file[0].name : '';
            newImg = file.length === 1 ? file[0] : null;

            if (file.length === 1) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('bookImage').src = e.target.result;
                };

                reader.readAsDataURL(file[0]);
            } else
                document.getElementById('bookImage').src = document.getElementById('bookImage').getAttribute(
                    'data-initial-src');
        }

        function setNewFile(e) {
            const file = e ? e.target.files : [];
            document.getElementById('pdfFileName').textContent = file.length === 1 ? file[0].name : '';
        }

        function resetFields() {
            document.getElementById('bookNameInput').value = document.getElementById('bookNameInput').getAttribute(
                'data-old-value');
            document.getElementById('editionInput').value = document.getElementById('editionInput').getAttribute(
                'data-old-value');
            document.getElementById('isbnInput').value = document.getElementById('isbnInput').getAttribute(
                'data-old-value');
            document.getElementById('authorInput').value = document.getElementById('authorInput').getAttribute(
                'data-old-value');
            document.getElementById('publisherInput').value = document.getElementById('publisherInput').getAttribute(
                'data-old-value');
            document.getElementById('publishDateInput').value = document.getElementById('publishDateInput').getAttribute(
                'data-old-value');
            document.getElementById('descriptionInput').value = document.getElementById('descriptionInput').getAttribute(
                'data-old-value');
            document.getElementById('physicalPriceInput').value = document.getElementById('physicalPriceInput')
                .getAttribute('data-old-value');
            document.getElementById('inStockInput').value = document.getElementById('inStockInput').getAttribute(
                'data-old-value');
            document.getElementById('filePriceInput').value = document.getElementById('filePriceInput').getAttribute(
                'data-old-value');
            document.getElementById('imageInput').value = '';
            document.getElementById('filePathInput').value = '';
        }
    </script>
@endsection
