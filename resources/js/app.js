import './bootstrap'

/*
|--------------------------------------------------------------------------
| Flight Search Controller
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    FlightSearch.init()
})

const FlightSearch = {

state:{
    passengers:{
        adult:1,
        child:0,
        infant:0
    },
    activeDropdown:null,
    selectedIndex:-1
},


/*
|--------------------------------------------------------------------------
| Init
|--------------------------------------------------------------------------
*/

init(){

    this.initSwapAirports()
    this.initTripTypeLogic()
    this.initAirportAutocomplete()
    this.initPassengerSelector()
    this.initClickOutside()
    this.updatePassengerUI()

},


/*
|--------------------------------------------------------------------------
| Swap Airports
|--------------------------------------------------------------------------
*/

initSwapAirports(){

    const btn=document.getElementById("swapAirports")
    if(!btn) return

    btn.addEventListener("click",()=>{

        const originDisplay=document.querySelector('[name="origin_display"]')
        const destDisplay=document.querySelector('[name="destination_display"]')

        const origin=document.querySelector('[name="origin"]')
        const dest=document.querySelector('[name="destination"]')

        if(!originDisplay || !destDisplay) return

        ;[originDisplay.value,destDisplay.value]=[
            destDisplay.value,
            originDisplay.value
        ]

        if(origin && dest){
            ;[origin.value,dest.value]=[
                dest.value,
                origin.value
            ]
        }

    })

},


/*
|--------------------------------------------------------------------------
| Trip Type Logic
|--------------------------------------------------------------------------
*/

initTripTypeLogic(){

    const radios=document.querySelectorAll('input[name="trip_type"]')
    const returnField=document.getElementById("returnDateField")

    if(!radios.length || !returnField) return

    radios.forEach(radio=>{
        radio.addEventListener("change",()=>{
            returnField.classList.toggle(
                "hidden",
                radio.value==="oneway" && radio.checked
            )
        })
    })

},


/*
|--------------------------------------------------------------------------
| Airport Autocomplete
|--------------------------------------------------------------------------
*/

initAirportAutocomplete(){

    const inputs=document.querySelectorAll(".airport-input")

    inputs.forEach(input=>{

        let debounceTimer

        input.addEventListener("input",()=>{

            clearTimeout(debounceTimer)

            debounceTimer=setTimeout(()=>{

                const query=input.value.trim()

                if(query.length<2){
                    this.hideResults(input)
                    return
                }

                this.fetchAirports(input,query)

            },300)

        })


        /*
        |--------------------------------------------------------------------------
        | Keyboard Navigation
        |--------------------------------------------------------------------------
        */

        input.addEventListener("keydown",(e)=>{

            const dropdown=input.parentElement
                .querySelector(".autocomplete-results")

            if(!dropdown) return

            const items=dropdown.querySelectorAll(".airport-item")
            if(!items.length) return

            if(e.key==="ArrowDown"){

                e.preventDefault()

                this.state.selectedIndex++

                if(this.state.selectedIndex>=items.length)
                    this.state.selectedIndex=0

                this.highlightItem(items)

            }

            if(e.key==="ArrowUp"){

                e.preventDefault()

                this.state.selectedIndex--

                if(this.state.selectedIndex<0)
                    this.state.selectedIndex=items.length-1

                this.highlightItem(items)

            }

            if(e.key==="Enter"){

                e.preventDefault()

                const item=items[this.state.selectedIndex]
                if(item) item.click()

            }

        })

    })

},


/*
|--------------------------------------------------------------------------
| Fetch Airports
|--------------------------------------------------------------------------
*/

async fetchAirports(input,query){

    try{

        const res=await fetch(`/api/airports?q=${encodeURIComponent(query)}`)
        if(!res.ok) throw new Error("API error")

        const airports=await res.json()

        this.renderAirportResults(input,airports)

    }catch(err){

        console.error("Airport API error:",err)

    }

},


/*
|--------------------------------------------------------------------------
| Render Airport Results
|--------------------------------------------------------------------------
*/

renderAirportResults(input,airports){

    const results=input.parentElement
        .querySelector(".autocomplete-results")

    if(!results) return

    results.innerHTML=""

    if(!airports.length){

        results.innerHTML=
        `<div class="p-3 text-sm text-gray-500">No airports found</div>`

        results.style.display="block"
        return
    }

    airports.forEach(airport=>{

        const item=document.createElement("div")

        item.className="airport-item"

        item.innerHTML=`
        <div class="airport-icon">✈</div>

        <div class="airport-info">

            <div class="airport-city">
                ${airport.city}
                <span class="iata">(${airport.iata_code})</span>
            </div>

            <div class="airport-name">
                ${airport.airport_name}
            </div>

        </div>
        `

        item.addEventListener("click",()=>{

            input.value=airport.display_name

            const hidden=input.parentElement
                .querySelector('input[type="hidden"]')

            if(hidden) hidden.value=airport.iata_code

            results.style.display="none"
            this.state.selectedIndex=-1

            this.saveRecentSearch(airport.display_name)

        })

        results.appendChild(item)

    })

    results.style.display="block"
    this.state.activeDropdown=results

},


/*
|--------------------------------------------------------------------------
| Highlight Keyboard Selection
|--------------------------------------------------------------------------
*/

highlightItem(items){

    items.forEach(el=>el.classList.remove("bg-gray-100"))

    const current=items[this.state.selectedIndex]

    if(current){

        current.classList.add("bg-gray-100")

        current.scrollIntoView({
            block:"nearest"
        })

    }

},


/*
|--------------------------------------------------------------------------
| Hide Results
|--------------------------------------------------------------------------
*/

hideResults(input){

    const results=input.parentElement
        .querySelector(".autocomplete-results")

    if(results) results.style.display="none"

},


/*
|--------------------------------------------------------------------------
| Passenger Selector
|--------------------------------------------------------------------------
*/

initPassengerSelector(){

    const toggle=document.getElementById("passengerToggle")
    const popup=document.getElementById("passengerPopup")

    if(!toggle || !popup) return

    toggle.addEventListener("click",()=>{
        popup.classList.toggle("hidden")
    })

    document.querySelectorAll(".plus").forEach(btn=>{
        btn.addEventListener("click",()=>{
            const type=btn.dataset.type
            this.state.passengers[type]++
            this.updatePassengerUI()
        })
    })

    document.querySelectorAll(".minus").forEach(btn=>{
        btn.addEventListener("click",()=>{

            const type=btn.dataset.type

            if(type==="adult" && this.state.passengers.adult===1) return

            if(this.state.passengers[type]>0)
                this.state.passengers[type]--

            this.updatePassengerUI()

        })
    })

},


/*
|--------------------------------------------------------------------------
| Update Passenger UI
|--------------------------------------------------------------------------
*/

updatePassengerUI(){

    const p=this.state.passengers

    const adult=document.getElementById("adultCount")
    const child=document.getElementById("childCount")
    const infant=document.getElementById("infantCount")

    if(adult) adult.innerText=p.adult
    if(child) child.innerText=p.child
    if(infant) infant.innerText=p.infant

    const summary=
        `${p.adult} Adult`+
        (p.child?` , ${p.child} Child`:"")+
        (p.infant?` , ${p.infant} Infant`:"")

    const el=document.getElementById("passengerSummary")
    if(el) el.innerText=summary

},


/*
|--------------------------------------------------------------------------
| Close Dropdowns
|--------------------------------------------------------------------------
*/

initClickOutside(){

    document.addEventListener("click",(e)=>{

        document.querySelectorAll(".autocomplete-results")
        .forEach(drop=>{
            if(!drop.parentElement.contains(e.target))
                drop.style.display="none"
        })

        const popup=document.getElementById("passengerPopup")

        if(popup && !popup.parentElement.contains(e.target))
            popup.classList.add("hidden")

    })

},


/*
|--------------------------------------------------------------------------
| Recent Searches
|--------------------------------------------------------------------------
*/

saveRecentSearch(route){

    let searches=
        JSON.parse(localStorage.getItem("recentFlights")) || []

    searches.unshift(route)

    searches=[...new Set(searches)].slice(0,5)

    localStorage.setItem(
        "recentFlights",
        JSON.stringify(searches)
    )

}

}