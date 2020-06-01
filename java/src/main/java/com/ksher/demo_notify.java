package com.ksher;


import java.util.HashMap;
import java.util.Map;

/**
 * @caption: 支付回调
 * @author: apei
 * @date: 2019/6/6 17:41
 */
@RestController
@RequestMapping
public class demo_notify {

    /**
     * 支付回调
     * @param request
     * @param response
     * @return
     */
    @RequestMapping(value = "/notify",method = RequestMethod.POST,produces = "application/json; charset=utf-8")
    public Map<?,?> notify(HttpServletRequest request, HttpServletResponse response) {

        // 注意：必须按这个结构返回
        Map<String, String> result = new HashMap<>();
        result.put("result", "SUCCESS");
        result.put("msg", "OK");
        return result;
    }
}