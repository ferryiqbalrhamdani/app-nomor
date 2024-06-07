<div class="row">
    <div class="col-12 col-lg-3">
        <div class="mb-3 mt-2">
            Show <select wire:model.live='perPage' class=" card-hover" aria-label="Small select example">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select> entries
        </div>
    </div>
    <div class="col-12 col-lg-6 text-center">
        <div class="mt-1 mb-3">
            {{$slot}}
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-1">
        <div class="mb-3 shadow-sm ">
            <input wire:model.live='search' type="text" class="form-control card-hover" placeholder="Cari">
        </div>
    </div>
</div>