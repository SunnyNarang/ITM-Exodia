package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;

/**
 * Created by Sunny Narang on 13-08-2016.
 */

public class AttendanceData {
    String total,attended,subject,went,out_of;
    static String total_class="0",total_gone="0";
    public AttendanceData(String total,String attended){
        this.total = total;
        this.attended = attended;
    }

    public String getTotal() {
        return total;
    }

    public String getAttended() {
        return attended;
    }

    public String getSubject() {
        return subject;
    }

    public String getWent() {
        return went;
    }

    public String getOut_of() {
        return out_of;
    }

    public AttendanceData(String subject,  String went, String out_of) {
        this.subject = subject;
        this.went = went;
        this.out_of = out_of;
    }

    public static ArrayList<AttendanceData> jsonToArraylist(String json,String json2,String roll) throws JSONException {
        ArrayList<AttendanceData> arrayList = new ArrayList<>();
        ArrayList<String> codes = new ArrayList<>();
        ArrayList<String> absent = new ArrayList<>();
        ArrayList<String> total_class_code = new ArrayList<>();
        arrayList.add(new AttendanceData("12","55"));
        JSONArray codesjson = new JSONArray(json2);
        for(int i=0;i<codesjson.length();i++){
            JSONObject obj = codesjson.getJSONObject(i);
            codes.add(obj.getString("code"));
            Log.i("Codes",obj.getString("code"));
            absent.add("0");
            total_class_code.add("0");
        }

        JSONArray dataobj = new JSONArray(json);
        String[] faduData=null;
        int pos=-1;
        for(int i=0;i<dataobj.length();i++){
            JSONObject obj = dataobj.getJSONObject(i);
            String stu_data = obj.getString("data");
            String sub_code = obj.getString("code");
            if(stu_data!=null||!stu_data.equalsIgnoreCase(""))
            faduData = stu_data.split(",");
            for(int k=0;k<codes.size();k++){
                if(codes.get(k).equalsIgnoreCase(sub_code)){
                    pos=k;
                    break;
                }
            }
            //pos = codes.indexOf(sub_code);

            if(pos!=-1){
            for(int j =0;j<faduData.length;j++){
                if(faduData[j].equalsIgnoreCase("BSMN1SC14012")){
                int absent_temp=Integer.parseInt(absent.get(pos))+1;
                    absent.remove(pos);
                absent.add(pos,absent_temp+"");
            }}
            int total_temp=Integer.parseInt(total_class_code.get(pos))+1;
            total_class_code.remove(pos);
                total_class_code.add(pos,total_temp+"");}
        }

        for(int i=0;i<codes.size();i++){
            arrayList.add(new AttendanceData(codes.get(i),(Integer.parseInt(total_class_code.get(i))-Integer.parseInt(absent.get(i)))+"",total_class_code.get(i)));
            Log.i("code",codes.get(i)+" "+(Integer.parseInt(total_class_code.get(i))-Integer.parseInt(absent.get(i)))+" "+total_class_code.get(i));
            total_class=Integer.parseInt(total_class)+Integer.parseInt(total_class_code.get(i))+"";
            total_gone=Integer.parseInt(total_gone)+Integer.parseInt(total_class_code.get(i))-Integer.parseInt(absent.get(i))+"";
        }
        return arrayList;

    }
}
