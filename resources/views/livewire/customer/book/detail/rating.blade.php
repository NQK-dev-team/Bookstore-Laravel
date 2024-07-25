<div class="container bg-light rounded mt-3 mb-3 py-3">
    <h4>Product Ratings</h4>
    <div class='ratingPanel rounded d-flex align-items-md-center flex-md-row flex-column container-fluid p-3 mt-3'>
        <div>
            <p class='mb-0'>
                <span class='fs-4 fw-bold'>{{ $average_rating }}</span> out of 5
            </p>
            <div class='fs-4 text-warning'>{!! displayRatingStars($average_rating) !!}</div>
        </div>
        <div class='ms-md-5 mt-3 mt-md-0'>
            <div class='d-none d-md-flex align-items-center'>
                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value=""
                    wire:model="ratingFilter" id="allStar" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white me-1 ratingFilter" for="allStar">All</label>

                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value="1"
                    wire:model="ratingFilter" id="1Star" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="1Star">1 Star</label>

                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value="2"
                    wire:model="ratingFilter" id="2Star" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="2Star">2 Stars</label>

                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value="3"
                    wire:model="ratingFilter" id="3Star" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="3Star">3 Stars</label>

                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value="4"
                    wire:model="ratingFilter" id="4Star" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="4Star">4 Stars</label>

                <input type="radio" class="btn-check" name="ratingFilter" autocomplete="off" value="5"
                    wire:model="ratingFilter" id="5Star" x-on:click="$wire.fetchRating()">
                <label class="btn border border-1 bg-white ms-1 ratingFilter" for="5Star">5 Stars</label>
            </div>
            <div class='d-flex d-md-none d-flex align-items-center'>
                <p class='mb-0'>Select</p>
                <select class="form-select pointer border-1 ms-3" wire:model="ratingFilter" id="selectRatingFilter"
                    aria-label="Select rating star" x-on:change="$wire.fetchRating()">
                    <option value="">All</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
        </div>
    </div>
    @if ($isBought)
        <hr>
        <form class='d-flex flex-column' wire:submit="submitRating">
            <div class='d-flex align-items-center px-1'>
                <p class='mb-0'>Rating</p>
                <div class="star-rating">
                    <input type="radio" id="5-stars" name="rating" value="5" wire:model="rating" />
                    <label for="5-stars" class="star">&#9733;</label>
                    <input type="radio" id="4-stars" name="rating" value="4" wire:model="rating" />
                    <label for="4-stars" class="star">&#9733;</label>
                    <input type="radio" id="3-stars" name="rating" value="3" wire:model="rating" />
                    <label for="3-stars" class="star">&#9733;</label>
                    <input type="radio" id="2-stars" name="rating" value="2" wire:model="rating" />
                    <label for="2-stars" class="star">&#9733;</label>
                    <input type="radio" id="1-star" name="rating" value="1" wire:model="rating" />
                    <label for="1-star" class="star">&#9733;</label>
                </div>
            </div>
            <textarea class='form-control mt-1' placeholder='Comment about this product' rows=3 wire:model="comment"
                id="comment"></textarea>
            <div class='mt-3 d-flex flex-sm-row flex-column'>
                <div class='text-danger ms-1'>
                    @error('rating')
                        {{ $message }}
                    @enderror
                </div>
                <div class='ms-auto'>
                    <button class='btn btn-sm btn-danger {{ $hasRated ? '' : 'd-none' }}' type='button'
                        data-bs-toggle="modal" data-bs-target="#deleteRatingModal">Delete</button>
                    <button class='btn btn-sm btn-secondary mx-1' type='reset'
                        x-on:click="$wire.rating=0; $wire.comment='';">Reset</button>
                    <button class='btn btn-sm btn-primary' type='submit'>Submit</button>
                </div>
            </div>
        </form>
        <div class="modal fade" id="deleteRatingModal" tabindex="-1" aria-labelledby="Delete rating modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5">Notice</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <p>Do you want to delete your rating on this book?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            x-on:click="$wire.deleteRating()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($isRatingExist && count($ratings))
        <hr class='mb-0'>
    @endif
    <div class='d-flex flex-column'>
        @if (!$isRatingExist)
            <h5 class='fw-normal mx-auto mt-3 text-secondary'>This Book Has No Rating Yet.</h5>
        @elseif(count($ratings))
            <div>
                @foreach ($ratings as $elem)
                    <div class='border-bottom py-3'>
                        <div class='d-flex'>
                            <img alt='User profile image'
                                src='{{ $elem->image ? route('temporary-url.image', ['path' => $elem->image]) : asset('assets/images/default_profile_image.png') }}'
                                class='ratingImage'>
                            <div class='ms-2'>
                                <p class='mb-0 fw-medium'>{{ $elem->name }}</p>
                                <div class='text-warning'>{!! displayRatingStars($elem->star) !!}</div>
                                <small
                                    class='text-secondary'>{{ date('F j, Y H:i:s', strtotime($elem->updated_at)) }}</small>
                                <p class='mt-3'>{{ $elem->comment }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='mx-auto mt-3'>
                <button class='btn btn-light border border-dark'><i class="bi bi-chevron-down"></i> Load More</button>
            </div>
        @endif
    </div>
</div>
