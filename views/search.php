<!-- Banner con imagen de fondo y formulario centrado -->
<div class="banner">
        <div class="overlay"></div>
        <div class="container">
            <h1 class="h1 fw-bolder col-5">Encuentra tu alojamiento perfecto</h1>
            <h3 class="h3 text-white">Estas a un paso de reservar tus vacaciones soñadas</h3>
            <form class="search-form mt-4 border border-3 border-warning p-2">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="destination" class="form-label">Destino</label>
                        <select class="form-control form-select select2" id="destination" name="destination">
                            <!-- Los países se cargarán aquí -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="checkin" class="form-label">Fecha de entrada</label>
                        <input type="date" class="form-control" id="checkin">
                    </div>
                    <div class="col-md-2">
                        <label for="checkout" class="form-label">Fecha de salida</label>
                        <input type="date" class="form-control" id="checkout">
                    </div>
                    
                    <div class="col-md-2">
                <label for="guests" class="form-label">Huéspedes y camas</label>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="guestsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="guestsSummary">1 adulto, 1 cama</span>
                    </button>
                    <div class="dropdown-menu p-3" aria-labelledby="guestsDropdown">
                        <div class="mb-3">
                            <label for="adults" class="form-label">Adultos</label>
                            <input type="number" class="form-control" id="adults" name="adults" value="1" min="1">
                        </div>
                        <div class="mb-3">
                            <label for="children" class="form-label">Niños</label>
                            <input type="number" class="form-control" id="children" name="children" value="0" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="beds" class="form-label">Camas</label>
                            <input type="number" class="form-control" id="beds" name="beds" value="1" min="1">
                        </div>
                        <button class="btn btn-primary w-100" type="button" onclick="updateGuestsSummary()">Aplicar</button>
                    </div>
                </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>