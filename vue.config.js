module.exports = {
    // options...
    devServer: {
        proxy: {
            // 프록시 요청을 보낼 api의 시작 부분
            '/v1': {
                // 프록시 요청을 보낼 서버의 주소
                target: 'https://kapi.kakao.com/v1',
                changeOrigin: true,
                logLevel: 'debug',
            },

        }
    }
}