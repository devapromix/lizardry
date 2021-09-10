object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 487
  ClientWidth = 984
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Panel1: TPanel
      Height = 487
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 984
    ExplicitHeight = 487
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Panel7: TPanel
      Left = 703
      Height = 487
      inherited Panel16: TPanel
        ExplicitTop = 100
      end
      inherited Panel11: TPanel
        ExplicitLeft = 0
        ExplicitTop = 25
        ExplicitWidth = 281
      end
      inherited Panel17: TPanel
        ExplicitLeft = 0
        ExplicitTop = 125
      end
      inherited Panel18: TPanel
        ExplicitLeft = 0
        ExplicitTop = 150
      end
    end
    inherited Panel1: TPanel
      Height = 487
    end
    inherited Panel9: TPanel
      Width = 422
      Height = 487
      inherited Panel10: TPanel
        Width = 422
      end
      inherited StaticText1: TStaticText
        Width = 422
      end
    end
  end
end
