package com.ExodiaSolutions.sunnynarang.itmexodia;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;
import java.util.HashMap;

/**
 * Created by shriram chobuey on 1/8/2017.
 */

public class Link implements Serializable{
    private static Link link = null;
    HashMap<String,String> hashMapLink = new HashMap<>();
    private Link(){
    }

    public static Link getInstance(){
        if(link == null){
            link = new Link();
            return link;
        }else{
            return link;
        }
    }

    public static void setInstance(Link link1){
        link = link1;
    }

    public void setHashMapLink(JSONArray jsonArray) throws JSONException {
        for(int i=0;i<jsonArray.length();i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            hashMapLink.put(obj.getString("name"), obj.getString("link"));
        }
    }

    public HashMap<String,String> getHashMapLink(){
        return hashMapLink;
    }

}
