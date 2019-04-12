package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.content.Context;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by Sunny Narang on 09-08-2016.
 */

public class Att_list_class {
    
    String time,course,branch,classes,sem,date,subject,suject_id,section_id,timetable_id,absent_st_list;
    String batch;
    public String getTime() {
        return time;
    }

    public Att_list_class(){}


    public Att_list_class(String course, String branch, String classes, String sem, String date, String subject) {
        this.course = course;
        this.branch = branch;
        this.classes = classes;
        this.sem = sem;
        this.date = date;
        this.subject = subject;
    }


    public Att_list_class(String course, String branch, String classes, String sem, String date, String subject, String subject_id , String section_id, String time,String timetable_id,String absent_st_list) {
        
        this.course = course;
        this.branch = branch;
        this.classes = classes;
        this.sem = sem;
        this.time = time;
        this.suject_id=subject_id;
        this.section_id=section_id;
        this.date = date;
        this.subject = subject;
        this.timetable_id = timetable_id;
        this.absent_st_list = absent_st_list;
    }
    public String getCourse() {
        return course;
    }

    public String getBranch() {
        return branch;
    }

    public String getClasses() {
        return classes;
    }
    public String getAbsent_st_list() {
        return absent_st_list;
    }

    public String getSem() {
        return sem;
    }

    public String getDate() {
        return date;
    }

    public String getSubject() {
        return subject;
    }

    public String getSuject_id() {
        return suject_id;
    }

    public String getsection_id() {
        return section_id;
    }

    public String getsubject() {
        return subject;
    }
    public String getTimetable_id() {
        return timetable_id;
    }


    public static ArrayList<Att_list_class> jsonToArraylist(String json, Context c){
        ArrayList<Att_list_class> arrayList = new ArrayList<>();

      //  Toast.makeText(c, "xfhdhfdhdhdhdh"+json, Toast.LENGTH_SHORT).show();
        try {

            JSONArray root= new JSONArray(json);
            for(int i=0;i<root.length();i++)
            {
                    JSONObject jsonObject = root.optJSONObject(i);

                    String att_date= jsonObject.optString("att_date");
                    String course= jsonObject.optString("COURSE_NAME");
                    String sub_id=jsonObject.optString("subjectcode");
                    String section_id=jsonObject.optString("sectionid");
                    String class_name= jsonObject.optString("SECNAME");
                    String subject_name = jsonObject.getString("subjectcode");
                    String branch=jsonObject.optString("BRANCH_NAME");
                    String sem=jsonObject.optString("SEMESTER");
                    String time=jsonObject.optString("PeriodSlot");
                    String timetable_id = jsonObject.optString("TIMETABLEID");
                    String std_absent_list = jsonObject.optString("stu_reg_id");
                    Att_list_class att_list_class=new Att_list_class(course,branch,class_name,sem,att_date,subject_name,sub_id,section_id,time,timetable_id,std_absent_list);
                    arrayList.add(att_list_class);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return arrayList;
    }
}
