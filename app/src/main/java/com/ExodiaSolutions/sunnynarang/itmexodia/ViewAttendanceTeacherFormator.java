package com.ExodiaSolutions.sunnynarang.itmexodia;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by shriram on 8/14/2016.
 */

public class ViewAttendanceTeacherFormator {
    
    String name,roll,attended,out_of;

    public ViewAttendanceTeacherFormator(String name, String roll, String attended, String out_of) {
        this.name = name;
        this.roll = roll;
        this.attended = attended;
        this.out_of = out_of;
    }

    public String getAttended() {
        return attended;
    }

    public String getRoll() {
        return roll;
    }

    public String getName() {
        return name;
    }

    public String getOut_of() {
        return out_of;
    }

    public static ArrayList<ViewAttendanceTeacherFormator> jsonToArraylist(String json,String batch){
        ArrayList<ViewAttendanceTeacherFormator> arrayList = new ArrayList<>();

        try {

            JSONArray root= new JSONArray(json);

            for(int i=0;i<root.length();i++)
            {
                JSONObject jsonObject = root.optJSONObject(i);
                if(batch.equalsIgnoreCase("ALL")){
                String name= jsonObject.optString("name");
                String roll= jsonObject.optString("nroll");
                String present=jsonObject.optString("present");
                String out_of = jsonObject.optString("out_of");

                ViewAttendanceTeacherFormator att=new ViewAttendanceTeacherFormator(name,roll,present,out_of);
                arrayList.add(att);}

                else{
                    if(jsonObject.optString("batch").equalsIgnoreCase(batch)){
                        String name= jsonObject.optString("name");
                        String roll= jsonObject.optString("nroll");
                        String present=jsonObject.optString("present");
                        String out_of = jsonObject.optString("out_of");

                        ViewAttendanceTeacherFormator att=new ViewAttendanceTeacherFormator(name,roll,present,out_of);
                        arrayList.add(att);}

                }
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return arrayList;

    }
    
}
