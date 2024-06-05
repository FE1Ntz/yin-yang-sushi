<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

</script>

<template>
    <DefaultLayout>
        <div class="h-[500px] bg-[url('img/home-banner.png')] bg-cover flex items-center">
            <div class="font-bold font-montserrat text-white ml-[5%]">
                <!--//bg-black text-white dark:text-black dark:bg-white-->
                <h2 class="text-[40px]">
                    Вітаємо<br>в YING&YANG —
                </h2>
                <p class="text-[15px]">
                    мережі ресторанів японської та паназійської кухонь. <br>
                    Якщо вам захотілося спробувати щось в закладі, <br> замовити доставку або забрати їжу з собою, ви за
                    адресою.
                </p>
            </div>
        </div>
        <div class="flex flex-col font-montserrat dark:text-white text-black w-full mt-[50px]">
            <div class="md:w-[700px] xl:w-[900px] px-6 border-b border-t border-black dark:border-white p-8 mx-auto">
                <h3 class="font-bold text-[30px]">Смачно</h3>
                <p>YING&YANG кілька разів на місяць оновлює асортимент
                    і поповнює його авторськими новинками , але залишається
                    вірним традиційною рецептурою і технологій приготування.
                    Від рису для суші до оригінальних рол сетів, салатів,
                    солодощів і напоїв - все втілює в собі майстерність і
                    ентузіазм наших команд.
                </p>
            </div>
            <div class="md:w-[700px] xl:w-[900px] border-b px-6 border-black dark:border-white p-8 mx-auto">
                <h3 class="font-bold text-[30px]">Вигідно</h3>
                <p>Ми піклуємося про баланс ціни і якості. Тому постійно тішимо наших
                    клієнтів новими подарунками, вводимо унікальні щомісячні та щотижневі акції,
                    влаштовуємо конкурси і піклуємося про те, щоб у вас залишилися тільки приємні враження.
                </p>
            </div>
            <div class="md:w-[700px] xl:w-[900px] border-b px-6 border-black dark:border-white p-8 mb-[50px] mx-auto">
                <h3 class="font-bold text-[30px]">Швидко</h3>
                <p>Кожен співробітник команди YING&YANG знає, наскільки важливо скоротити очікування
                    замовлення. Ми економимо ваш час на всіх етапах , від оформлення до доставки. А ще
                    паралельно відкриваємо нові ресторани кожен тиждень, щоб улюблені суші були ще ближче.
                </p>
            </div>
        </div>
        <div class="bg-[url('img/location-banner.png')] flex-wrap bg-cover bg-center overflow-x-auto text-white flex font-montserrat h-[500px] px-[40px] font-bold">
            <div class="flex items-center">
                <h3 class="text-[30px] sm:text-[40px]">Ми знаходимося за адресою:</h3>
            </div>
            <div class="flex w-full items-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1262.982422660001!2d25.38058967237541!3d50.72059135892177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47259b21b7a5e0cd%3A0xd3f60459f981d3ff!2z0J_RltGG0LAm0J_QuNCy0L4g0JzQsNGA0LrQtdGC!5e0!3m2!1sen!2sua!4v1717021133543!5m2!1sen!2sua"
                        class="w-full h-[265px]"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </DefaultLayout>
</template>

