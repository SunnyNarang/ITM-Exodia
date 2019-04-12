package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.content.Context;
import android.content.DialogInterface;
import android.graphics.Color;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.amulyakhare.textdrawable.TextDrawable;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.facebook.drawee.backends.pipeline.Fresco;

import org.apache.commons.io.FileUtils;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

public class EditAttendance extends AppCompatActivity implements android.widget.CompoundButton.OnCheckedChangeListener {

    ListView edit_listview;
    CheckBox checkBox;
    String offline_temp_att;
    String time,course_select,batch_select,sem_select,class_select,branch_select,roll_teacher,name_teacher,subject_select,subject_id,class_id,timestamp,tid;
    String c_id,br_id,section_id,period;
    CustomAdapter3 adapter;
    String[] color = {"EF5350", "AB47BC", "7E57C2", "5C6BC0", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};


    ArrayList<Student> temp_arraylist;

    boolean doubleBackToExitPressedOnce = false;

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
            {if (doubleBackToExitPressedOnce) {
                finish();
            }

                this.doubleBackToExitPressedOnce = true;
                Toast.makeText(this, "Please tap BACK again to exit", Toast.LENGTH_SHORT).show();

                new Handler().postDelayed(new Runnable() {

                    @Override
                    public void run() {
                        doubleBackToExitPressedOnce=false;
                    }
                }, 2000);}
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onBackPressed() {
        if (doubleBackToExitPressedOnce) {
            super.onBackPressed();
            return;
        }

        this.doubleBackToExitPressedOnce = true;
        Toast.makeText(this, "Please tap BACK again to exit", Toast.LENGTH_SHORT).show();

        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                doubleBackToExitPressedOnce=false;
            }
        }, 2000);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Fresco.initialize(EditAttendance.this);
        setContentView(R.layout.activity_edit_attendance);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Edit Attendance");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        batch_select=getIntent().getStringExtra("batch");
        course_select=getIntent().getStringExtra("course_select");
        sem_select=getIntent().getStringExtra("sem_select");
        class_select=getIntent().getStringExtra("class_select");
        branch_select=getIntent().getStringExtra("branch_select");
        roll_teacher=getIntent().getStringExtra("roll_teacher");
        name_teacher=getIntent().getStringExtra("name_teacher");
        subject_select = getIntent().getStringExtra("subject_select");
        subject_id = getIntent().getStringExtra("subject_id");
        class_id = getIntent().getStringExtra("class_id");
        timestamp = getIntent().getStringExtra("timestamp");
        time = getIntent().getStringExtra("time");
        c_id = getIntent().getStringExtra("c_id");
        br_id = getIntent().getStringExtra("br_id");
        section_id = getIntent().getStringExtra("section_id");
        period= getIntent().getStringExtra("period");
        tid= getIntent().getStringExtra("tid");

       temp_arraylist = (ArrayList<Student>) getIntent().getSerializableExtra("data");
      //  Toast.makeText(this, ""+temp_arraylist.size(), Toast.LENGTH_SHORT).show();
        edit_listview = (ListView) findViewById(R.id.edit_listview);

        adapter = new CustomAdapter3(EditAttendance.this,temp_arraylist);
        edit_listview.setAdapter(adapter);

    }



    @Override
    public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
        int pos=edit_listview.getPositionForView(compoundButton);
        if(pos!=edit_listview.INVALID_POSITION){
            Student std = temp_arraylist.get(pos);
            if(std.getStatus()==1)
            { std.setStatus(0);
             //   Toast.makeText(EditAttendance.this , std.getName()+" Absent", Toast.LENGTH_SHORT).show();
            }
            else {
                std.setStatus(1);
               // Toast.makeText(EditAttendance.this , std.getName()+" Present", Toast.LENGTH_SHORT).show();
            }

        }
    }

    /*
        @Override
        public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
            Student std = temp_arraylist.get(i);
            Toast.makeText(EditAttendance.this, "gfhg"+std.getStatus(), Toast.LENGTH_SHORT).show();
            if(std.getStatus()==1)
                std.setStatus(0);
            else
                std.setStatus(1);
        }

    */
    class CustomAdapter3 extends ArrayAdapter<Student> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<Student> arrayList) {
            super(context, R.layout.edit_attendance_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.edit_attendance_card, parent, false);

            Student s = getItem(pos);
            TextView roll = (TextView) convertView.findViewById(R.id.edit_roll);

            TextView name = (TextView) convertView.findViewById(R.id.edit_name);
            ImageView imageView = (ImageView) convertView.findViewById(R.id.edit_att_imge);
            int col=pos;
            if(pos>=10){
                col=pos%10;
            }
            TextDrawable drawable = TextDrawable.builder()
                    .buildRound(String.valueOf(s.getName().charAt(0)), Color.parseColor("#"+color[col]));
            imageView.setImageDrawable(drawable);
           CheckBox status_checkbox = (CheckBox) convertView.findViewById(R.id.edit_checkbox);

            name.setText(s.getName());
            roll.setText(s.getRoll());
            if(s.getStatus()==1){
                status_checkbox.setChecked(true);
            }
            status_checkbox.setOnCheckedChangeListener(EditAttendance.this);


           // checkBox.setTag(s);
            return convertView;

        }
    }

    private void readItems()  {
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll_teacher+"temp_attendance.txt");
        try {
            offline_temp_att = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_temp_att = "";
        }
    }

    private void writeItems(String s) {
        File filesDir = getFilesDir();
        //Toast.makeText(this, ""+roll_teacher, Toast.LENGTH_SHORT).show();
        File todoFile = new File(filesDir, roll_teacher+"temp_attendance.txt");
        try {
            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

public void ok_list(View v)
        {

            String tobewritten = "";
            Student s = temp_arraylist.get(0);
            String subject=subject_id;
            String teacher1=name_teacher;
            String teacher2="0";
            String tid= this.tid;
            String period= this.period;
            String periodTo="0";
            String date=timestamp;
            String time0=time;
            String section_id=this.section_id;
            String regId=roll_teacher;
            String section_name=class_select;

            String first_part = course_select+"+"+branch_select+"+"+section_name+"+"+sem_select+"+"+subject+"+"+teacher1+"+"+teacher2+"+"+tid+"+"+period+"+"+periodTo+"+"+date+"+"+time0+"+"+section_id+"+"+regId;
            String attendance="null";
            for(int i=0;i<temp_arraylist.size();i++)
            {
                Student std = temp_arraylist.get(i);
                if(std.getStatus()==0){
                    if(attendance.equals("null"))
                         attendance=""+std.getRoll();
                    else{
                        attendance+=","+std.getRoll();
                    }
                }
            }


            tobewritten=first_part+"+"+attendance;

            readItems();
            if(offline_temp_att.equalsIgnoreCase(""))
                writeItems(tobewritten);
            else
            {
                writeItems(offline_temp_att+"&&"+tobewritten);
            }
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setMessage("    Attendance Completed.")
                    .setCancelable(false)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            finish();
                        }
                    });
            AlertDialog alert = builder.create();
            alert.show();

    }

    public void select(View v){
            for(int i=0;i<temp_arraylist.size();i++){
                Student s = temp_arraylist.get(i);
                s.setStatus(1);
            }
        adapter.notifyDataSetChanged();
    }
    public void deselect(View v){
        for(int i=0;i<temp_arraylist.size();i++){
            Student s = temp_arraylist.get(i);
            s.setStatus(0);
        }
        adapter.notifyDataSetChanged();

    }


}
