const API_URL = '/app/api.php';
const CATEGORY_URL = '/app/category.php';

const PER_ROW_COUNT = 12; 

const pofolHook = document.querySelector('.work-list');

const catgHook = document.getElementById('catg-hook');
const noItemHook = document.getElementById("no-item-hook");
const moreBtn = document.querySelector('.no-more-button');
const form = document.forms['frm'];
const categorySection = document.querySelector('.no-category-section');


function extractYoutubeId(url) {
    const regExp = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const match = url.match(regExp);
    return match ? match[1] : null;
}


function getItemTemplate(type, item) {
    if (type === 'pofol') {
        const { thumb_image, title, sort_no, direct_url, category_name, extra1, no, regdate } = item;
        const youtubeId = extractYoutubeId(direct_url);

		const imgSrc = thumb_image.startsWith('/') ? thumb_image : `/uploads/board/${thumb_image}`;

        return `
            <li data-no="${no}" data-regdate="${regdate}" class="cursor-video">
				<a href="javascript:void(0);" data-youtube-id="${youtubeId}">
					 <figure style="background-image: url('${imgSrc}');">
						<span class="category poppins">${category_name}</span>
					</figure>
					<div class="txt">
						<h3 class="poppins">${title}</h3>
					</div>
				</a>
			</li>
        `;
    }

    if (type === 'catg') {
        const { name, no } = item;
        return `<li class="swiper-slide no-category__item">
                    <label for="category_no_${no}">
                        <input type="checkbox" name="category_no" id="category_no_${no}" value="${no}" data-content="${name}">
                        <span>${name}</span>
                    </label>
                </li>`;
    }
}



async function handleChange(){
	form.addEventListener('change', renderItems.bind(null, false));
}


function getParams(){
	const fd = new FormData(form);
	return new URLSearchParams(Object.fromEntries(fd));
}

function getCheckedCategoryValue(){
	const categoryItems = [...document.querySelectorAll('[name=category_no]')]; 
	let value = categoryItems.filter(item => item.checked && item.value.length).map(item => item.value)

	return value; 
}

async function renderItems() {
	
	const params = getParams();
	params.set('category_no', getCheckedCategoryValue()); 
    const requestUrl = API_URL + '?' + params.toString();

    const resp = await fetch(requestUrl);
    const data = await resp.json();
	
	console.log(data);
	pofolHook.innerHTML = null;


	let noItemsMessage = document.querySelector('.no-items-message');

	data.rows.length === 0 && !noItemsMessage && (() => {

		noItemsMessage = document.createElement('div');
		noItemsMessage.className = 'no-items-message';
		noItemsMessage.innerHTML = `
			<h3>NO ITEM</h3>
			<p>조건에 맞는 포토폴리오가 없습니다.</p>
		`;
		noItemHook.appendChild(noItemsMessage);
		return;
	})();




    let firstOst;
    data.rows.forEach((item, idx) => {
        pofolHook.insertAdjacentHTML('beforeend', getItemTemplate('pofol', item));
        if (idx === 0) {
            firstOst = pofolHook.lastElementChild.offsetTop;
        }
    });
}

async function handleMore(){

	moreBtn.addEventListener('click', async () => {
		
		const regdate = pofolHook.lastElementChild.dataset.regdate;

		const params = getParams(); 

		params.append('regdate', regdate); 
		params.append('category_no', getCheckedCategoryValue());

		const requestUrl = API_URL + '?' + params.toString();
		
		const resp = await fetch(requestUrl);
		const data = await resp.json();
		
		displayMoreBtn(data.rows.length);

		if(data.rows.length === 0) return; 

		let firstOst;
		
		data.rows.forEach((item, idx) => {
			pofolHook.insertAdjacentHTML('beforeend', getItemTemplate('pofol', item));

			if(idx === 0){
				firstOst = pofolHook.lastElementChild.offsetTop
			}
		})
		window.scrollTo({top: firstOst - categorySection.offsetHeight - 250, behavior: 'smooth' });
	});
}

function displayMoreBtn(count){
	if(count < PER_ROW_COUNT){
		moreBtn.style.display = 'none'; 
	} else {
		moreBtn.style.display = 'flex';
	}
}

class App 
{
	static async run(){

		const catgResp = await fetch(CATEGORY_URL);
		const catgData = await catgResp.json(); 

		catgData.rows.forEach(item => {
			catgHook.insertAdjacentHTML('beforeend', getItemTemplate('catg', item));
		});

		await renderItems();
		handleMore();
		handleChange();
	}
}

App.run();

