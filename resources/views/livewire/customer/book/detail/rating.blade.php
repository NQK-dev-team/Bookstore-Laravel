<div class="container bg-light rounded mt-3 mb-3 py-3">
    <h4>Product Ratings <span id='totalRatings' class='fw-normal'></span></h4>
    <div class='ratingPanel rounded d-flex align-items-md-center flex-md-row flex-column container-fluid p-3 mt-3'>
        <div>
            <h6>
                <span class='fs-4'>{{ $average_rating }}</span> out of 5
            </h6>
            <div class='fs-4 text-warning'>{!! displayRatingStars($average_rating) !!}</div>
        </div>
        <div class='ms-md-5 mt-3 mt-md-0'>
            <div class='d-none d-md-flex align-items-center'>
                <input onchange="setRatingFilter(event,'all')" type="radio" class="btn-check" name="ratingFilter"
                    id="allStar" autocomplete="off" checked>
                <label class="btn border border-1 bg-white me-1 ratingFilter" for="allStar">All</label>

                <input onchange="setRatingFilter(event,'1')" type="radio" class="btn-check" name="ratingFilter"
                    id="1Star" autocomplete="off">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="1Star">1 Star</label>

                <input onchange="setRatingFilter(event,'2')" type="radio" class="btn-check" name="ratingFilter"
                    id="2Star" autocomplete="off">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="2Star">2 Stars</label>

                <input onchange="setRatingFilter(event,'3')" type="radio" class="btn-check" name="ratingFilter"
                    id="3Star" autocomplete="off">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="3Star">3 Stars</label>

                <input onchange="setRatingFilter(event,'4')" type="radio" class="btn-check" name="ratingFilter"
                    id="4Star" autocomplete="off">
                <label class="btn border border-1 bg-white mx-1 ratingFilter" for="4Star">4 Stars</label>

                <input onchange="setRatingFilter(event,'5')" type="radio" class="btn-check" name="ratingFilter"
                    id="5Star" autocomplete="off">
                <label class="btn border border-1 bg-white ms-1 ratingFilter" for="5Star">5 Stars</label>
            </div>
            <div class='d-flex d-md-none d-flex align-items-center'>
                <p class='mb-0'>Select</p>
                <select onchange="selectRatingFilter(event)" class="form-select pointer border-1 ms-3"
                    aria-label="Select rating start">
                    <option value="all" selected>All</option>
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
        <form class='d-flex flex-column'>
            <div class='d-flex align-items-center px-1'>
                <p class='mb-0'>Rating</p>
                <div class="star-rating">
                    <input type="radio" id="5-stars" name="rating" value="5" />
                    <label for="5-stars" class="star">&#9733;</label>
                    <input type="radio" id="4-stars" name="rating" value="4" />
                    <label for="4-stars" class="star">&#9733;</label>
                    <input type="radio" id="3-stars" name="rating" value="3" />
                    <label for="3-stars" class="star">&#9733;</label>
                    <input type="radio" id="2-stars" name="rating" value="2" />
                    <label for="2-stars" class="star">&#9733;</label>
                    <input type="radio" id="1-star" name="rating" value="1" />
                    <label for="1-star" class="star">&#9733;</label>
                </div>
            </div>
            <textarea class='form-control mt-1' placeholder='Comment about this product' rows=3></textarea>
            <div class='mt-3 ms-auto'>
                <button id='deleteBtn' class='btn btn-sm btn-danger {{ $hasRated ? '' : 'd-none' }}' type='button'
                    x-on:click="">Delete</button>
                <button class='btn btn-sm btn-secondary mx-1' type='reset'>Reset</button>
                <button class='btn btn-sm btn-primary' type='submit'>Submit</button>
            </div>
        </form>
    @endif
    <hr class='mb-0'>
    <div class='d-flex flex-column'>
        <h5 class='fw-normal mx-auto mt-3 none text-secondary' id='noRating'>This Product Has No Rating</h5>
        <div id='ratingList'>
        </div>
        <div class='mx-auto mt-3' id='showBtn'>
            <button onclick='showAll=true; fetchRatings()' class='border-0 bg-light'>Show All <i
                    class="bi bi-chevron-down"></i></button>
        </div>
    </div>
</div>
