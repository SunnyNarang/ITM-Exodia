package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by Sunny Narang on 12-08-2016.
 */

public class ViewReportStudent {
    String name,status,roll;

    public ViewReportStudent(String roll, String name, String status) {
        this.roll = roll;
        this.name = name;
        this.status = status;
    }

    public String getName() {
        return name;
    }

    public String getStatus() {
        return status;
    }

    public String getRoll() {
        return roll;
    }

    public static ArrayList<ViewReportStudent> jsonToArraylist (String json,String []absent_list){
        ArrayList<ViewReportStudent> arraylist = new ArrayList<>();
        String json_roll,json_name,status; //status 1 matlab present and 0 matlab absent...
        try {
            JSONArray jsonArray =  new JSONArray(json);
            for(int i=0;i<jsonArray.length();i++)
            {
                JSONObject obj = jsonArray.optJSONObject(i);
                json_roll = obj.getString("vstu_rollno");
                json_name = obj.getString("vstu_name");
                status = "1";
                for(int j=0;j<absent_list.length;j++){
                    if(absent_list[j].equalsIgnoreCase(json_roll)){
                        status = "0";
                    }
                }
                ViewReportStudent vr = new ViewReportStudent(json_roll,json_name,status);
                arraylist.add(vr);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

        return arraylist;
    }
}
