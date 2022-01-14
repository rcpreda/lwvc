<template>
    <div class="h-full">
        <div id="video-container" class="bg-gray-800 relative">
            <div class="absolute w-40 h-28 bg-gray-900 bottom-0">
                
            </div>
        </div>
        <div class="absolute w-full h-12 flex gap-4 justify-center items-center bg-gray-100 bottom-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 cursor-pointer text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 cursor-pointer text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</template>

<style scoped>
    #video-container{
        height: calc(100% - 3rem)
    }
</style>